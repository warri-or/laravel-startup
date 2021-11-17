<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * If specified, this namespace is automatically applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $namespace_modules = 'App\Http\Modules';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware(['web','language'])->namespace($this->namespace)->group(base_path('routes/web.php'));
            Route::prefix('api')->middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
            Route::middleware(['web','auth','language'])->namespace($this->namespace)->group(base_path('routes/app.php'));
            Route::prefix('admin')->middleware('web')->namespace($this->namespace)->group(base_path('routes/auth.php'));

            Route::prefix('admin')
                 ->middleware(['web','auth','auth_permission','language','module_permission:'.MODULE_SUPER_ADMIN])
                 ->namespace($this->namespace)
                 ->group(base_path('routes/admin/super_admin.php'));

            Route::prefix('admin')
                 ->middleware(['web','auth','auth_permission','language','module_permission:'.MODULE_USER_ADMIN,'role_permission'])
                 ->namespace($this->namespace)
                 ->group(base_path('routes/admin/admin.php'));

            Route::prefix('admin')
                 ->middleware(['web','auth','auth_permission','language','module_permission:'.MODULE_USER_ADMIN,'role_permission'])
                 ->namespace($this->namespace)
                 ->group(base_path('routes/admin/product_manager.php'));

            Route::middleware(['web','auth','auth_permission','language','module_permission:'.MODULE_USER_ADMIN,'role_permission'])
                 ->namespace($this->namespace_modules)
                 ->group(base_path('routes/modules/settings.php'));

            Route::middleware(['web','auth','auth_permission','language','module_permission:'.MODULE_USER_ADMIN,'role_permission'])
                 ->namespace($this->namespace_modules)
                 ->group(base_path('routes/modules/notification_and_messaging.php'));

            Route::middleware(['web','auth','auth_permission','language','module_permission:'.MODULE_USER_ADMIN,'role_permission'])
                 ->namespace($this->namespace_modules)
                 ->group(base_path('routes/modules/payment.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
