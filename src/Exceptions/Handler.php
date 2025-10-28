<?php

namespace BabeRuka\ProfileHub\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Exception;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];
     

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $exception) {
            if ($exception instanceof HttpException && $exception->getStatusCode() === 419) {
                return redirect()->route('profilehub::login')->with('message', 'OPPS! Your session has expired :-( :-<. Please log in again.');

            }
        });
    }
    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() === 419) {
            return response()->view('profilehub.vendor.errors.419', ['exception' => $exception, 'message' => 'OPPS! Your session has expired :-( Please log in again.'], 419);
        }

        return parent::render($request, $exception);
    }
   
}
