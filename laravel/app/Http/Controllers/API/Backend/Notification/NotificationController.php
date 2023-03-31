<?php

namespace App\Http\Controllers\API\Backend\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Notification\NotificationAllListResource;
use App\Http\Resources\Backend\Notification\NotificationListResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $notifications = Notification::with('order', 'order.order_product', 'order.customer')->latest()->paginate(5);
        return NotificationAllListResource::collection($notifications);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function unreadNotifications(): AnonymousResourceCollection
    {
        $notifications = Notification::with('user', 'order', 'order.order_product')->where('status', 1)->latest()->take(10)->get();
        return NotificationListResource::collection($notifications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($order, $notification = null)
    {
        $data['order_id'] = $order->id;
        $data['notification'] = $notification;
        $data['status'] = 1;
        $data['user_id'] = null;
        Notification::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_notifications_as_read($id)
    {
        $notification = Notification::findOrFail($id);
        $data['status'] = 0;
        $data['user_id'] = auth()->user()->id;
        $notification->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
