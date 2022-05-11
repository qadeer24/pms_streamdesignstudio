<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Message;
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
}

