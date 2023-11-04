<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TooManyRequestsHttpException) {
            // If the request expects JSON, return a JSON response
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You are posting too frequently. Please wait a bit.'], 429);
            }

            // For web requests, redirect back with an error message
            return redirect()->back()->with('error', 'You are posting too frequently. Please wait a bit.');
        }

        // Make sure to call the parent method if the exception is not the one we're looking for
        return parent::render($request, $exception);
    }
}
