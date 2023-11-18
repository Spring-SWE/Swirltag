<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Status;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Register rate limiters for API access.
        $this->registerRateLimiters();

        // Register routes.
        $this->registerRoutes();

        // Register custom route model bindings.
        $this->registerRouteModelBindings();
    }

    /**
     * Register the rate limiters for the application.
     */
    protected function registerRateLimiters(): void
    {
        // General API rate limiter.
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Specific rate limiter for posts to throttle at 10 requests per minute.
        RateLimiter::for('post_limit', function (Request $request) {
            return Limit::perMinute(10)->by(optional($request->user())->id ?: $request->ip());
        });

         // Limit likes to 20 per minute.
         RateLimiter::for('like_limit', function (Request $request) {
            return Limit::perMinute(20)->by(optional($request->user())->id ?: $request->ip());
        });

        // Limit likes to 50 per minute.
        RateLimiter::for('follow_limit', function (Request $request) {
            return Limit::perMinute(50)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Register the application's routes.
     */
    protected function registerRoutes(): void
    {
        // Register API routes with 'api' middleware and prefix.
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Register web routes with 'web' middleware.
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Register custom route model bindings.
     */
    protected function registerRouteModelBindings(): void
    {
        // Custom binding for 'Status' to automatically resolve with 'media & user' relationship.
        Route::bind('status', function ($value) {
            return Status::where('id', $value)->with(['user', 'media'])->firstOrFail();
        });
    }
}
