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
        $sys_logo = Setting::where('name', 'sys_logo')->first()->val ?? '/storage/photos/2/logo/logo-vizion.jpg';
        $sys_logo_mobile = Setting::where('name', 'sys_logo_mobile')->first()->val ?? '/storage/photos/2/logo/logo-vizion.jpg';
        $sys_favicon = Setting::where('name', 'sys_favicon')->first()->val ?? '/storage/photos/2/product/empty-photo.jpg';
        $sys_title = Setting::where('name', 'sys_title')->first()->val;
        $sys_address = Setting::where('name', 'sys_address')->first()->val;
        $sys_phone = Setting::where('name', 'sys_phone')->first()->val;
        $sys_hotline = Setting::where('name', 'sys_hotline')->first()->val;
        $sys_worktime = Setting::where('name', 'sys_worktime')->first()->val;
        $sys_mail = Setting::where('name', 'sys_mail')->first()->val;
        $sys_fanpage = Setting::where('name', 'sys_fanpage')->first()->val;
        $sys_youtube = Setting::where('name', 'sys_youtube')->first()->val;
        $sys_footer = Setting::where('name', 'sys_footer')->first()->val;
        $sys_keyword = Setting::where('name', 'sys_keyword')->first()->val;


        Config::set('app.sys_logo', $sys_logo);
        Config::set('app.sys_logo_mobile', $sys_logo_mobile);
        Config::set('app.sys_favicon', $sys_favicon);
        Config::set('app.sys_title', $sys_title);
        Config::set('app.sys_address', $sys_address);
        Config::set('app.sys_phone', $sys_phone);
        Config::set('app.sys_hotline', $sys_hotline);
        Config::set('app.sys_worktime', $sys_worktime);
        Config::set('app.sys_mail', $sys_mail);
        Config::set('app.sys_fanpage', $sys_fanpage);
        Config::set('app.sys_youtube', $sys_youtube);
        Config::set('app.sys_footer', $sys_footer);
        Config::set('app.sys_keyword', $sys_keyword);

//        View::share('adminLogo', $adminLogo);
//        View::share('frontendLogo', $frontendLogo);

    }
}
