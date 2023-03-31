<?php

namespace App\Http\Controllers\API\Backend\Ticket;

use App\Helpers\Helper;
use App\Http\Controllers\API\Frontend\Ticket\FrontendTicketController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Ticket\TicketListResource;
use App\Http\Resources\Frontend\Ticket\TicketDetailsResource;
use App\Models\Ticket;
use App\Models\TicketPhoto;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $tickets = Ticket::with(['status',  'customer'])->where('ticket_id', null)->latest()->paginate(20);
        return TicketListResource::collection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);


        $ticket_data['subject'] = $request->input('subject');
        $ticket_data['description'] = $request->input('description');
        $ticket_data['user_id'] = auth()->user()->id;
        $ticket_data['ticket_status_id'] = $request->input('status') ?? 2;
        $ticket_data['ticket_id'] = $request->input('ticket_id');

        if ($request->exists('ticket_id')) {
            $parent_ticket = Ticket::findOrFail($request->input('ticket_id'));
            $temp_data['ticket_status_id'] = $request->input('ticket_status_id') ?? 2;
            $parent_ticket->update($temp_data);
        }

        $ticket = Ticket::create($ticket_data);


        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
//
//                $extension = $photo->getClientOriginalExtension();
//                $extension = strtolower($extension);
//

                $img_data = getimagesize($photo);
                $height =  $img_data[1];
                $width =  $img_data[0];
                $file = $photo;
                $path = 'images/uploads/tickets/';
                $name = Str::slug(auth()->user()->name, '-')  . '-' .  Str::slug(Carbon::now()->toDayDateTimeString(), '-') . random_int(1000,9999);
                $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
                $data['ticket_id'] = $ticket->id;
                TicketPhoto::create($data);
            }

        }
        return response()->json(['msg'=>'Ticket Submitted Successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TicketDetailsResource
     */
    public function show(int $id): TicketDetailsResource
    {
        $ticket = Ticket::with(['photos', 'status', 'user', 'customer', 'replay', 'replay.photos', 'replay.status', 'replay.user', 'replay.customer'])->findOrFail($id);
        return new TicketDetailsResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
       $data['ticket_status_id'] = $request->input('ticket_status_id');
       $ticket = Ticket::findOrFail($id);
       $ticket->update($data);
       return response()->json(['msg'=>'Ticket Status Updated Successfully']);
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
