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
                                ->where('messages.sender_id',$request->sender_id)->where('messages.receiver_id',$request->receiver_id)
                                ->select(
                                        'message as message',
                                        'sender_id as sender',
                                        'receiver_id as receiver'
                                    )
                                ->get();


        return Response::json([
                                'status'        => "success",
                                'msg'           => "People message fetched successfully",
                                'data'          => [
                                                        'people messages' =>  $messages 
                                                ]
                            ], 200);
    }
}

