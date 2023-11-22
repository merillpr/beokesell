<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Interfaces\UserInterface;
use DB;

class UserController extends Controller
{
    protected $userInterface;

    /**
     * Create a new constructor for this controller
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    /**
     * Register User
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function registerUser(RegisterRequest $request)
    {
        return $this->userInterface->registerUser($request);
    }

    /**
     * Login User
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function loginUser(LoginRequest $request)
    {
        return $this->userInterface->loginUser($request);
    }

    /**
     * Logout User
     *
     * @param  LogoutRequest  $request
     * @return Response
     */
    public function logoutUser()
    {
        return $this->userInterface->logoutUser();
    }
}