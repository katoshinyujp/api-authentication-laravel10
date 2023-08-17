<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*'))
            {
                Log::error($e->getMessage(), $request->all());
                return response([
                    'code' => intval(($e->getCode() ?: 404).'000'),
                    'status' => config('api.response_status_errors'),
                    'data' => null,
                    'message' => $e->getMessage(),
                ], $e->getCode() ?: 404);
            }
        });
    }
}
