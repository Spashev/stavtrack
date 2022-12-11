<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends BaseController
{
    public function register (RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $success['status'] =  true;
            $success['message'] =  'User Created Successfully';
            $success['token'] = $user->createToken(env("TOKEN_NAME", "token"))->plainTextToken;

            return $this->sendResponse($success, 'User register successfully.');

        } catch (\Throwable $th) {

            return $this->sendError('User creation error.', [
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function login (LoginRequest $request)
    {
        try {
            if(!\Auth::attempt($request->only(['email', 'password']))){

                return $this->sendError('Validation Error.', [
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ]);
            }

            $user = User::where('email', $request->email)->first();


            $success['status'] =  true;
            $success['message'] =  'User Logged In Successfully';
            $success['token'] = $user->createToken(env("TOKEN_NAME", "token"))->plainTextToken;

            return $this->sendResponse($success, 'User register successfully.');
        } catch (\Throwable $th) {

            return $this->sendError('Authentication error.', [
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];

        return response($response, 200);
    }
}
