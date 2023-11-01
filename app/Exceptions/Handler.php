<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Throwable;

class Handler extends ExceptionHandler
{
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


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() === 503) {
            return response(['message' => 'We are performing maintenance. Please check back shortly.'], 503);
        }

        return parent::render($request, $exception);
    }
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
