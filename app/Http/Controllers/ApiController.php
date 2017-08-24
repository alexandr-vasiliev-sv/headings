<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * @var int
     */
    private $statusCode = Response::HTTP_OK;

    /**
     * @param $code
     * @return $this
     */
    protected function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function getAuthUser()
    {
        return auth()->user();
    }

    /**
     * @param $message
     * @return mixed
     */
    public function respondSuccessMessage($message)
    {
        return $this->setStatusCode(Response::HTTP_OK)->respond([
            'message' => $message
        ]);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function respondSuccess($data)
    {
        return $this->setStatusCode(Response::HTTP_OK)->respond($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function respond($data)
    {
        return response()->json($data, $this->statusCode);
    }
}
