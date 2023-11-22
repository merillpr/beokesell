<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use App\Traits\ResponseAPI;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseAPI;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Handle when user not authenticated
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->error(message: 'Not Authenticated', statusCode: 401);
    }
}
