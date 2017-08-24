<?php

namespace App\Http\Controllers;

use App\Entities\Heading;

class HeadingsController extends ApiController
{
    protected $headingsPerPage = 5;

    public function index()
    {
        return $this->respondSuccess(
            Heading::paginate($this->headingsPerPage)
        );
    }

    public function show(Heading $heading)
    {
        return $this->respondSuccess(
            $heading
        );
    }

    public function subscribeOrUnSubscribe(Heading $heading)
    {
        $response = auth()->user()->subscriptions()->toggle($heading);

        return $this->respondSuccessMessage(
            empty($response['attached'])
                ? 'You have successfully unsubscribed to this section'
                : 'You have successfully subscribed to this section'
        );
    }

}
