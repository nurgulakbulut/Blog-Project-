<?php

namespace App\Jobs;

use App\Mail\PostReminder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();
        $users->each(function ($user) {
            $newPostsForUser = Post::query()
                ->whereIn('category_id', $user->followed_categories()->pluck('id'))
                ->where('created_at', '>=', now()->subWeek())
                ->orderBy('created_at', 'ASC')
                ->get();
            if ($newPostsForUser->count() > 0) {
                // E-posta gonderilinsin
                Mail::to($user)->send(new PostReminder($user, $newPostsForUser));

            }

        });

    }
}
