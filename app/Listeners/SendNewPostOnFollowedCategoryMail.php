<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Mail\NewPostOnFollowedCategory;
use Illuminate\Support\Facades\Mail;

class SendNewPostOnFollowedCategoryMail
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
        $categoryFollowers = $event->post->category->followers;

        foreach ($categoryFollowers as $follower) {
            Mail::to($follower)->send(new NewPostOnFollowedCategory($event->post));
        }
    }
}
