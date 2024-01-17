<?php

namespace App\Repositories;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\EmailVerificationRequest;
use App\Http\Requests\User\EmailVerificationResend;
use App\Interfaces\UserInterface;
use App\Traits\ResponseAPI;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Jobs\user\SendEmailVerificationJob;
use DB;
use Illuminate\Support\Carbon;

class UserRepository implements UserInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function registerUser(RegisterRequest $request)
    {   
        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['id'] = $user->id;

            $this->sendOTP($user);
            DB::commit();
            return $this->success(data: $success, message: 'User register successfully.', statusCode: 201);
        } catch(\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function loginUser(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            Auth::user()->tokens()->delete();
            $user = Auth::user();
            if(!$user->is_verified){
                return $this->error(message: 'Email has not verified, verify your email first!', statusCode: 400);
            }
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

    public function emailVerification(EmailVerificationRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id','=',$request->id)->first();

            if($user->email_verified_at) {
                return $this->error(message: "Email has been verified!", statusCode: 400);
            }

            $time = now()->format('Y-m-d H:i:s');
            $t1 = Carbon::parse($time);
            $t2 = Carbon::parse($user->request_otp_at);
            $diffSec = $t2->diffInSeconds($t1);
            if($diffSec > 86400) {
                return $this->error(message: "The code you entered has expired!", statusCode: 400);
            }

            if($user->otp == $request->code) {
                $user->otp = null;
                $user->is_verified = true;
                $user->email_verified_at = $time;
                $user->save();

                $success['email'] =  $user->email;
                $success['verified_at'] =  $user->email_verified_at;
                DB::commit();
                return $this->success(data: $success, message: "Email verified successfully!", statusCode: 200);
            }

            return $this->error(message: "The code you entered is incorrect!", statusCode: 400);

        } catch(\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage(), $e->getCode);
        }
    }

    public function resendVerification(EmailVerificationResend $request) {
        try{
            $user = User::where('email','=',$request->email)->first();

            if(!$user){
                return $this->error(message: "Email is not registered!", statusCode: 400);
            }else if($user->is_verified){
                return $this->error(message: "Email is verified!", statusCode: 400);
            }

            $this->sendOTP(user: $user);
            return $this->success(data:$user, message: "Code sent via email, check your email!", statusCode: 201);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode);
        }
    }

    protected function sendOTP(User $user)
    {
        DB::beginTransaction();
        try {
            $code = random_int(100000, 999999);
            dispatch(new SendEmailVerificationJob($user, $code));

            $user->otp = $code;
            $user->request_otp_at = now()->format('Y-m-d H:i:s');
            $user->save();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}