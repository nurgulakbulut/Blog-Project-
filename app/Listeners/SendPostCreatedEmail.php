<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Mail\PostCreated as PostCreatedMail;
use Illuminate\Support\Facades\Mail;

class SendPostCreatedEmail
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
     * @param  PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        Mail::to($event->post->user)->send(new PostCreatedMail($event->post));

    }
}
