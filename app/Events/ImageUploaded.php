<?php

namespace App\Events;

use App\Models\Image;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ImageUploaded implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function broadcastOn()
    {
        return new Channel('smart_wearable_glasses'); // 
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->image->id,
            'user_id' => $this->image->user_id,
            'caption' => $this->image->caption,
            'image' => asset('storage/' . str_replace('public/', '', $this->image->image)),
            'created_at' => $this->image->created_at->toDateTimeString(),
        ];
    }

    public function broadcastAs()
    {
        return 'image.uploaded';
    }
}
