<?php

namespace EasifyAllegro\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \EasifyAllegro\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \EasifyAllegro\Http\Middleware\VerifyCsrfToken::class,
        \EasifyAllegro\Http\Middleware\MagicCurtain::class,
        \EasifyAllegro\Http\Middleware\SetTimeZone::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \EasifyAllegro\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \EasifyAllegro\Http\Middleware\RedirectIfAuthenticated::class,
    ];
}
