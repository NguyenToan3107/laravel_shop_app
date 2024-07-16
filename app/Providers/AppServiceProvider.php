<?php

namespace App\Providers;

use App\Models\Setting;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Builder::useVite();
        $adminLogo = Setting::where('key', 'admin_logo')->first()->value ?? 'storage/photos/2/logo/logo-vizion.jpg';
        $frontendLogo = Setting::where('key', 'frontend_logo')->first()->value ?? 'storage/photos/2/logo/logo-vizion.jpg';

        Config::set('app.admin_logo', $adminLogo);
        Config::set('app.frontend_logo', $frontendLogo);

        View::share('adminLogo', $adminLogo);
        View::share('frontendLogo', $frontendLogo);

    }
}
