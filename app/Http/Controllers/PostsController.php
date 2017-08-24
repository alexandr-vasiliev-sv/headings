<?php

namespace App\Http\Controllers;

use App\Entities\Heading;
use App\Jobs\SendNewPostEmail;
use Illuminate\Http\Response;
use App\Events\AddNewPost;

class PostsController extends ApiController
{
    protected $postsPerPage = 3;

    public function posts(Heading $heading)
    {
        return $this->respondSuccess(
            $heading->posts()
                ->with('author')
                ->latest()
                ->paginate($this->postsPerPage)
        );
    }

    public function store(Heading $heading)
    {
        $this->validate(request(), [
            'text' => 'required',
        ]);

        $post = $heading->posts()->create([
            'text' => request('text'),
            'user_id' => auth()->id()
        ]);

        $post->load('author');

        dispatch(new SendNewPostEmail($heading, $post));

        \Redis::publish('new-posts', json_encode($post));

        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respondSuccess([
                'post' => $post,
            ]);
    }
}
