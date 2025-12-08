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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'role_permission' => \App\Http\Middleware\RolePermissionMiddleware::class,
            'check.employee.status' => \App\Http\Middleware\CheckEmployeeStatus::class,
        ]);
        
        // Apply employee status check to all authenticated routes
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SystemHealthCheck::class,
            \App\Http\Middleware\CheckEmployeeStatus::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
