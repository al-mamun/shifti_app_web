<?php

namespace App\Http\Controllers\API\Frontend\Ticket;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Ticket\TicketDetailsResource;
use App\Http\Resources\Frontend\Ticket\TicketListResource;
use App\Models\Ticket;
use App\Models\TicketPhoto;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class FrontendTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $tickets = Ticket::with(['status'])->where('customer_id', auth()->user()->id)->where('ticket_id', null)->latest()->paginate(20);
        return TicketListResource::collection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->exists('type')) {
            $this->validate($request, [
                'description' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'subject' => 'required',
                'description' => 'required',
            ]);
        }

        $ticket_data['subject'] = $request->input('subject');
        $ticket_data['description'] = $request->input('description');
        $ticket_data['customer_id'] = auth()->user()->id;
        $ticket_data['ticket_status_id'] = 1;
        $ticket_data['ticket_id'] = $request->input('ticket_id');

        if ($request->exists('ticket_id')) {
            $parent_ticket = Ticket::findOrFail($request->input('ticket_id'));
            $temp_data['ticket_status_id'] = 3;
            $parent_ticket->update($temp_data);
        }

        $ticket = Ticket::create($ticket_data);


        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
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
    public function show($id)
    {
        $ticket = Ticket::with(['photos', 'status', 'user', 'customer', 'replay', 'replay.photos', 'replay.status', 'replay.user', 'replay.customer'])->findOrFail($id);
        return new TicketDetailsResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
