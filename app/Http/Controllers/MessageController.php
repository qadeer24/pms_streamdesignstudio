<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Message;
use App\Models\People;
use App\Events\MessageEvent;
use Illuminate\Http\Request;

use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    
    public function message(MessageRequest $request){
    	event(
                new MessageEvent(
                                    $request->input('message'),
                                    $request->input('sender_id'), 
                                    $request->input('receiver_id'), 
                )
            );

        $data         = Message::create($request->all());

        return Response::json([
            'status'        => "success",
            'msg'           => "Message send successfully"
        ], 200);
    }

    public function fetch_messages(Request $request)
    {
        $messages               =  Message::where('messages.active',1)
                                    ->leftjoin('people', 'people.id', '=', 'messages.sender_id')
                                    ->where('messages.sender_id',$request->sender_id)->where('messages.receiver_id',$request->receiver_id)
                                    ->orWhere('messages.sender_id',$request->receiver_id)->where('messages.receiver_id',$request->sender_id)
                                    ->select(
                                            'people.fname as name',
                                            'messages.id as _id',
                                            'messages.message as text',
                                            'sender_id as sender',
                                            'receiver_id as receiver',
                                            'messages.created_at as createdAt',
                                        )
                                    ->get();

                                // $people_vehicles->push(((object) array("vehicle_id" => "0")))

        foreach ($messages as $key => $message) {
            $messages[$key]->user =((object) array(
                                                    "_id" => $message->sender,
                                                    "avatar" => "https://placeimg.com/140/140/any",
                                                    "name" => $message->name,
                                                )); 
        }


        return Response::json([
                                'status'        => "success",
                                'msg'           => "People message fetched successfully",
                                'data'          => [
                                                        'people messages' =>  $messages 
                                                ]
                            ], 200);
    }
}

