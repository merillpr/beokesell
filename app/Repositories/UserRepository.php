<?php

namespace App\Repositories;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Interfaces\UserInterface;
use App\Traits\ResponseAPI;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class UserRepository implements UserInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function registerUser(RegisterRequest $request)
    {   
        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->success(data: $success, message: 'User register successfully.', statusCode: 201);
        } catch(\Exception $e) {
            return $this->error(message: $e->getMessage(), statusCode: $e->getCode());
        }
    }

    public function loginUser(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            Auth::user()->tokens()->delete();
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;['name'];
   
            return $this->success(data: $success, message: 'User login successfully.', statusCode: 201);
        }else{ 
            return $this->error(message: 'Unauthorised.', statusCode: 400);
        }
    }

    public function logoutUser()
    {
        Auth::user()->tokens()->delete();
        $data = Auth::user();
        return $this->success(message: 'User logout successfully', statusCode: 200, data: $data);
        
    }
}