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
    
    public $message;
    public $sender_id;
    public $receiver_id;
    public $event_id;

    public function __construct($message,$sender_id,$receiver_id)
    {
        $this->message      = $message;
        $this->sender_id    = $sender_id;
        $this->receiver_id  = $receiver_id;
         $this->event_id    = ($this->sender_id)."-".($this->receiver_id);
    }

    
    // public function broadcastOn()
    // {
    //     return ['my-channel'];
    // }

    public function broadcastOn()
    {
        return new PrivateChannel('myChannel'. "-".($this->event_id));
    }


    public function broadcastAs()
    {
        return 'my-event';
    }
}
