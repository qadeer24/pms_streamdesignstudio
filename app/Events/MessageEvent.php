<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $sml_id;
    public $big_id;
    public $message;
    public $sender_id;
    public $receiver_id;

    public function __construct($id, $sender_name, $created_at, $message, $sender_id, $receiver_id )
    {
        $this->sender_id    = $sender_id;
        $this->receiver_id  = $receiver_id;

        $this->message      = (object) array(
                                    "name"       => $sender_name,
                                    "_id"        => $id,
                                    "text"       => $message,
                                    "sender"     => $sender_id,
                                    "receiver"   => $receiver_id,
                                    "createdAt" => $created_at,
                                    "user"       => ((object) array(
                                        "_id"       => $sender_id,
                                        "avatar"    => "https://placeimg.com/140/140/any",
                                        "name"      => $sender_name
                                    ))
                                );

    }


    public function broadcastOn()
    {

        if( ($this->sender_id ) > $this->receiver_id ){
            $this->big_id  = ($this->sender_id );
            $this->sml_id  = ($this->receiver_id );
        }else{
            $this->big_id  = ($this->receiver_id );
            $this->sml_id  = ($this->sender_id );
        }

        
        return new Channel('my-channel' . '-'. ($this->sml_id).'-'. ($this->big_id) );
        // return new Channel('my-channel');
    }


    public function broadcastAs()
    {
        
        if( ($this->sender_id ) > $this->receiver_id ){
            $this->big_id  = ($this->sender_id );
            $this->sml_id  = ($this->receiver_id );
        }else{
            $this->big_id  = ($this->receiver_id );
            $this->sml_id  = ($this->sender_id );
        }

        return 'my-event' . '-'. ($this->sml_id).'-'. ($this->big_id);
        
        // return 'my-event';
    }
}
