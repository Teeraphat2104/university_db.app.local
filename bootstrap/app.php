<?php

use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\ForceJsonResponse;
use App\Support\JsonRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(
            prepend: [
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
            ],
            append: [
                ForceJsonResponse::class,
            ],
        );

        $middleware->alias([
            'admin' => EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if (! JsonRequest::wantsJson($request)) {
                return null;
            }

            return response()->json([
                'status' => 422,
                'message' => 'The given data was invalid.',
                'errors' => $exception->errors(),
            ], 422);
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if (! JsonRequest::wantsJson($request)) {
                return null;
            }

            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated.',
                'error' => 'Authentication is required to access this resource.',
            ], 401);
        });

        $exceptions->render(function (ModelNotFoundException $exception, Request $request) {
            if (! JsonRequest::wantsJson($request)) {
                return null;
            }

            return response()->json([
                'status' => 404,
                'message' => 'Resource not found.',
                'error' => 'The requested resource could not be found.',
            ], 404);
        });

        $exceptions->render(function (AuthorizationException $exception, Request $request) {
            if (! JsonRequest::wantsJson($request)) {
                return null;
            }

            return response()->json([
                'status' => 403,
                'message' => 'Forbidden.',
                'error' => 'You are not allowed to access this resource.',
            ], 403);
        });

        $exceptions->render(function (TokenMismatchException $exception, Request $request) {
            if (! JsonRequest::wantsJson($request)) {
                return null;
            }

            return response()->json([
                'status' => 419,
                'message' => 'Page expired.',
                'error' => 'CSRF token mismatch.',
            ], 419);
        });

        $exceptions->render(function (HttpException $exception, Request $request) {
            if (! JsonRequest::wantsJson($request)) {
                return null;
            }

            $statusCode = $exception->getStatusCode();

            [$message, $error] = match ($statusCode) {
                403 => ['Forbidden.', 'You are not allowed to access this resource.'],
                404 => ['Resource not found.', 'The requested resource could not be found.'],
                405 => ['Method not allowed.', 'The requested HTTP method is not allowed for this resource.'],
                429 => ['Too many requests.', 'Request limit exceeded. Please try again later.'],
                503 => ['Service unavailable.', 'The service is temporarily unavailable.'],
                default => ['Request failed.', $exception->getMessage() ?: 'The request could not be completed.'],
            };

            return response()->json([
                'status' => $statusCode,
                'message' => $message,
                'error' => $error,
            ], $statusCode);
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if (! JsonRequest::wantsJson($request)) {
                return null;
            }

            return response()->json([
                'status' => 500,
                'message' => 'Request failed.',
                'error' => app()->hasDebugModeEnabled()
                    ? $exception->getMessage()
                    : 'An unexpected error occurred.',
            ], 500);
        });
    })->create();
