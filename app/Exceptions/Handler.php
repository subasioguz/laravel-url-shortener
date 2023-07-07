<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?? '404 Not Found',
            ], 404);
        });

        $this->renderable(function (BadRequestException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?? 'Something went wrong.',
            ], 400);
        });
    }
}
