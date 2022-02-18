<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @Description Login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::getByEmail($request->email);
        $validator->after(function ($validator) use ($user) {
            if (!$user) {
                $validator->errors()->add('email', 'Email Does not exists.');
            } else if ($user) {
                if ($user->role_id == 1 || $user->role_id == 2) {
                    $validator->errors()->add('email', 'Sorry, You can only login on website.');
                }
            }
        });
        if ($validator->fails()) {
            $this->setResponse($validator->errors()->first(), 0, 422, []);
            return response()->json($this->response, $this->status);
        }
        $data = [];
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $data['token'] = $user->createToken('SPA')->accessToken;
            $data['user'] = Auth::user();
            $this->setResponse('user has been logged in.', 1, 200, $data);
        } else {
            // Unauthorized
            $this->setResponse('invalid credentials.', 0, 401, $data);
        }
        return response()->json($this->response, $this->status);
    }

    public function getCurrentUser()
    {
        $this->setResponse('success.', 1, 200, [
            'user' => auth()->user()
        ]);
        return response()->json($this->response, $this->status);
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        $this->setResponse('user logout.', 1, 200, []);
        return response($this->response, $this->status);
    }
}
