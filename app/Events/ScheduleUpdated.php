<?php

namespace App\Events;

use App\Models\Doctor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScheduleUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Doctor $doctor;

    /**
     * @return void
     */
    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('schedule.' . $this->doctor->id);
    }

        public function broadcastWith(): array
    {
        return [
            'doctor_id' => $this->doctor->id,
        ];
    }
}
