<?php

namespace App\Interfaces;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;

interface UserInterface
{
    /**
     * Register User
     * 
     * @param   RegisterRequest      $request
     * 
     * @method  POST api/register
     * @access  public
     */
    public function registerUser(RegisterRequest $request);

    /**
     * Login User
     * 
     * @param   LoginUser    $request
     * 
     * @method  POST api/login
     * @access  public
     */
    public function loginUser(LoginRequest $request);

    /**
     * Logout User
     * 
     * @method  POST api/logout
     * @access  public
     */
    public function logoutUser();
}