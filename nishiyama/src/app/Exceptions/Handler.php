<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Illuminate\Http\Request  $request
     *
     * @param  Throwable  $exception
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception) {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'result' => false,
                'message' => trans('messages.validation_error'),
                'errors' => $exception->errors()
            ], 422);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'result' => false,
                'message' => trans('messages.unauthorized'),
                'errors' => $exception->getMessage()
            ], 401);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'result' => false,
                'message' => trans('messages.not_found'),
                'errors' => $exception->getMessage()
            ], 404);
        }

        $data = [
            'result' => false,
            'message' => trans('messages.internal_server_error'),
            'errors' => $exception->getMessage()
        ];
        if (getenv('APP_ENV') == 'local' && getenv('APP_DEBUG')) {
            $data['trace'] = $exception->getTrace();
        }
        return response()->json($data, 500);
    }
}
