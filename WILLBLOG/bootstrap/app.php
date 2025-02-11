<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        //enregistrement du middleware pour role 1 ou 0 (check)
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
        ]);

        $middleware->appendToGroup('web', \App\Http\Middleware\InjectData::class);
        $middleware->appendToGroup('web', \App\Http\Middleware\InjectPosts::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
