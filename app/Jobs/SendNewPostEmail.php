<?php

namespace App\Jobs;

use App\Entities\Heading;
use App\Entities\Post;
use App\Notifications\NewPostAdded;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $heading;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Heading $heading, Post $post)
    {
        $this->post = $post;
        $this->heading = $heading;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->heading->subscriptions()->chunk(20, function ($users) {
            foreach ($users as $user) {
                $user->notify(new NewPostAdded($this->heading, $this->post));
            }
        });
    }
}
