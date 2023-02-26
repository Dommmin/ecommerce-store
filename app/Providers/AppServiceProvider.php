<?php

namespace App\Providers;

use App\Http\Controllers\RegisteredUserController;
use App\Models\ProductVariant;
use App\Observers\ProductVariantObserver;
use App\Overrides\src\Http\Controllers\AuthenticatedSessionController as AuthenticatedSessionControllerBase;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController as RegisteredUserControllerBase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias(AuthenticatedSessionControllerBase::class, AuthenticatedSessionController::class);
            $loader->alias(RegisteredUserControllerBase::class, RegisteredUserController::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);

        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
            ];
        });

        Inertia::share('csrf_token', function(){
            return csrf_token();
        });

        JsonResource::withoutWrapping();
        ProductVariant::observe(ProductVariantObserver::class);
    }
}
