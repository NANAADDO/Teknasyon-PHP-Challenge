<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class APIcontroller extends Controller
{

    public function authenticate_user_token($token)
    {
        try {

            $user = JWTAuth::authenticate($token);

            return [true, $user];


        } catch (JWTException $e) {

            return [false, ['message' => $e->getMessage(), 'statuscode' => $e->getStatusCode()],$e->getStatusCode()];

        }

    }


}
