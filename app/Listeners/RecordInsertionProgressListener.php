<?php
namespace App\Listeners;

use App\Events\RecordInsertionProgress;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordInsertionProgressListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RecordInsertionProgress   $event
     * @return void
     */
    public function handle($event)
    {
        // You can handle the progress update here, e.g., push to JavaScript via WebSockets or AJAX
        // In this example, we'll use session to store the progress
        session(['insertion_progress' => $event->progress]);
    }
}