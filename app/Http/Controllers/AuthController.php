<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            $response=['token' => $token];
            return $this->responseSuccess($response);
        } else {
            return $this->responseError('کلمه عبور یا نام کاربری صحیح نیست');
        }
    }
}
