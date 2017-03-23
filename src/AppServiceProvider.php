<?php

namespace LaravelEnso\Core;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\Classes\BreadcrumbsBuilder;
use LaravelEnso\Core\Classes\MenuManager\MenuGenerator;
use LaravelEnso\Core\Enums\ThemesEnum;
use LaravelEnso\Core\Http\Middleware\Impersonate;
use LaravelEnso\Core\Http\Middleware\VerifyActiveState;
use LaravelEnso\Core\Http\Middleware\VerifyRouteAccess;
use LaravelEnso\Localisation\Language;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesDepedencies();
        $this->loadMiddleware();
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'core');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->composeLayoutPage();
        $this->composeBreadcrubms();
    }

    private function publishesDepedencies()
    {
        $this->publishes([__DIR__.'/../config/laravel-enso.php' => config_path('laravel-enso.php')], 'core-config');
        $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'core-migration');
        $this->publishes([__DIR__.'/../resources/routes/web.php' => base_path('routes/web.php')], 'core-routes');
        $this->publishesClasses();
        $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'core-lang');
        $this->publishesViews();
        $this->publishesResources();
    }

    private function loadMiddleware()
    {
        $this->app['router']->aliasMiddleware('impersonate', Impersonate::class);
        $this->app['router']->aliasMiddleware('verifyActiveState', VerifyActiveState::class);
        $this->app['router']->aliasMiddleware('verifyRouteAccess', VerifyRouteAccess::class);
    }

    private function composeLayoutPage()
    {
        view()->composer('core::layouts.app', function ($view) {
            $user = request()->user();
            $userMenus = $user->role->menus->sortBy('order');
            $menu = new MenuGenerator($userMenus);
            $languages = Language::all();
            $themesEnum = new ThemesEnum();
            $colorThemes = $themesEnum->getJsonData();
            $pusherKey = env('PUSHER_KEY');
            $globalPreferences = $user->global_preferences;
            $colorTheme = json_decode($globalPreferences)->colorTheme;
            $sidebarCollapse = json_decode($globalPreferences)->sidebarCollapse ? 'sidebar-collapse' : '';
            $view->with(compact('user', 'menu', 'globalPreferences', 'colorThemes', 'colorTheme', 'sidebarCollapse', 'languages', 'pusherKey'));
        });
    }

    private function composeBreadcrubms()
    {
        view()->composer('core::partials.breadcrumbs', function ($view) {
            $userMenus = request()->user()->role->menus->sortBy('order');
            $breadcrumbsBuilder = new BreadcrumbsBuilder($userMenus);
            $breadcrumbs = $breadcrumbsBuilder->getBreadcrumbs();
            $view->with(compact('breadcrumbs'));
        });
    }

    private function publishesClasses()
    {
        $this->publishes([__DIR__.'/../resources/Classes/DataTable' => app_path('DataTable')], 'core-classes');
        $this->publishes([__DIR__.'/../resources/Classes/Controllers' => app_path('Http/Controllers')], 'core-controllers');
        $this->publishes([__DIR__.'/../resources/Classes/Requests' => app_path('Http/Requests')], 'core-requests');
        $this->publishes([__DIR__.'/../resources/Classes/Models' => app_path()], 'core-models');
        $this->publishes([__DIR__.'/notifications' => app_path('Notifications/vendor/laravel-enso')], 'core-notification');
    }

    private function publishesViews()
    {
        $this->publishes([__DIR__.'/../resources/views/pages' => resource_path('views/vendor/laravel-enso/core')], 'core-views');
        $this->publishes([__DIR__.'/../resources/views/layouts' => resource_path('views/layouts')], 'core-layouts');
        $this->publishes([__DIR__.'/../resources/views/partials' => resource_path('views/partials')], 'core-layouts');
        $this->publishes([__DIR__.'/../resources/views/includes' => resource_path('views/includes')], 'core-layouts');
        $this->publishes([__DIR__.'/../resources/views/auth' => resource_path('views/auth')], 'core-auth');
        $this->publishes([__DIR__.'/../resources/views/errors' => resource_path('views/errors')], 'core-errors');
    }

    private function publishesResources()
    {
        $this->publishes([__DIR__.'/../resources/assets/images' => resource_path('assets/images')], 'core-images');
        $this->publishes([__DIR__.'/../resources/assets/js' => resource_path('assets/js/vendor/laravel-enso')], 'core-pages-js');
        $this->publishes([__DIR__.'/../resources/assets/libs' => resource_path('assets/libs')], 'core-libs');
        $this->publishes([__DIR__.'/../resources/assets/main-js' => resource_path('assets/js')], 'core-main-js');
        $this->publishes([__DIR__.'/../resources/assets/sass' => resource_path('assets/sass')], 'core-sass');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}