<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class RecordInsertionProgress
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $progress;

    /**
     * Create a new event instance.
     *
     * @param  float  $progress
     * @return void
     */
    public function __construct($progress)
    {
        $this->progress = $progress;
    }
}