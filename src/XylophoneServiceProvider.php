<?php

namespace Xylophone\CRUD;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class XylophoneServiceProvider extends ServiceProvider
{
    use Stats, LicenseCheck;

    protected $commands = [
        \Xylophone\CRUD\app\Console\Commands\Install::class,
        \Xylophone\CRUD\app\Console\Commands\AddSidebarContent::class,
        \Xylophone\CRUD\app\Console\Commands\AddCustomRouteContent::class,
        \Xylophone\CRUD\app\Console\Commands\Version::class,
        \Xylophone\CRUD\app\Console\Commands\CreateUser::class,
        \Xylophone\CRUD\app\Console\Commands\PublishXylophoneUserModel::class,
        \Xylophone\CRUD\app\Console\Commands\PublishXylophoneMiddleware::class,
        \Xylophone\CRUD\app\Console\Commands\PublishView::class,
    ];

    // Indicates if loading of the provider is deferred.
    protected $defer = false;
    // Where the route file lives, both inside the package and in the app (if overwritten).
    public $routeFilePath = '/routes/xylophone/base.php';
    // Where custom routes can be written, and will be registered by Xylophone.
    public $customRoutesFilePath = '/routes/xylophone/custom.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->loadViewsWithFallbacks();
        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'xylophone');
        $this->loadConfigs();
        $this->registerMiddlewareGroup($this->app->router);
        $this->setupRoutes($this->app->router);
        $this->setupCustomRoutes($this->app->router);
        $this->publishFiles();
        $this->checkLicenseCodeExists();
        $this->sendUsageStats();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the CrudPanel object to Laravel's service container
        $this->app->singleton('crud', function ($app) {
            return new \Xylophone\CRUD\app\Library\CrudPanel\CrudPanel($app);
        });

        // load a macro for Route,
        // helps developers load all routes for a CRUD resource in one line
        if (! Route::hasMacro('crud')) {
            $this->addRouteMacro();
        }

        // register the helper functions
        $this->loadHelpers();

        // register the artisan commands
        $this->commands($this->commands);

        // register the services that are only used for development
        // if ($this->app->environment() == 'local') {
        //     if (class_exists('Laracasts\Generators\GeneratorsServiceProvider')) {
        //         $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        //     }
        //     if (class_exists('Xylophone\Generators\GeneratorsServiceProvider')) {
        //         $this->app->register('Xylophone\Generators\GeneratorsServiceProvider');
        //     }
        // }

        // map the elfinder prefix
        if (! \Config::get('elfinder.route.prefix')) {
            \Config::set('elfinder.route.prefix', \Config::get('xylophone.base.route_prefix').'/elfinder');
        }
    }

    public function registerMiddlewareGroup(Router $router)
    {
        $middleware_key = config('xylophone.base.middleware_key');
        $middleware_class = config('xylophone.base.middleware_class');

        if (! is_array($middleware_class)) {
            $router->pushMiddlewareToGroup($middleware_key, $middleware_class);

            return;
        }

        foreach ($middleware_class as $middleware_class) {
            $router->pushMiddlewareToGroup($middleware_key, $middleware_class);
        }
    }

    public function publishFiles()
    {
        $error_views = [__DIR__.'/resources/error_views' => resource_path('views/errors')];
        $xylophone_views = [__DIR__.'/resources/views' => resource_path('views/vendor/xylophone')];
        $xylophone_public_assets = [__DIR__.'/public' => public_path()];
        $xylophone_lang_files = [__DIR__.'/resources/lang' => resource_path('lang/vendor/xylophone')];
        $xylophone_config_files = [__DIR__.'/config' => config_path()];
        $elfinder_files = [
            __DIR__.'/config/elfinder.php'      => config_path('elfinder.php'),
            __DIR__.'/resources/views-elfinder' => resource_path('views/vendor/elfinder'),
        ];

        // sidebar_content view, which is the only view most people need to overwrite
        $xylophone_menu_contents_view = [
            __DIR__.'/resources/views/base/inc/sidebar_content.blade.php'      => resource_path('views/vendor/xylophone/base/inc/sidebar_content.blade.php'),
            __DIR__.'/resources/views/base/inc/topbar_left_content.blade.php'  => resource_path('views/vendor/xylophone/base/inc/topbar_left_content.blade.php'),
            __DIR__.'/resources/views/base/inc/topbar_right_content.blade.php' => resource_path('views/vendor/xylophone/base/inc/topbar_right_content.blade.php'),
        ];
        $xylophone_custom_routes_file = [__DIR__.$this->customRoutesFilePath => base_path($this->customRoutesFilePath)];

        // calculate the path from current directory to get the vendor path
        $vendorPath = dirname(__DIR__, 3);
        $gravatar_assets = [$vendorPath.'/creativeorange/gravatar/config' => config_path()];

        // establish the minimum amount of files that need to be published, for Xylophone to work; there are the files that will be published by the install command
        $minimum = array_merge(
            $error_views,
            // $xylophone_views,
            $xylophone_public_assets,
            // $xylophone_lang_files,
            $xylophone_config_files,
            $xylophone_menu_contents_view,
            $xylophone_custom_routes_file,
            $gravatar_assets,
            $elfinder_files
        );

        // register all possible publish commands and assign tags to each
        $this->publishes($xylophone_config_files, 'config');
        $this->publishes($xylophone_lang_files, 'lang');
        $this->publishes($xylophone_views, 'views');
        $this->publishes($xylophone_menu_contents_view, 'menu_contents');
        $this->publishes($error_views, 'errors');
        $this->publishes($xylophone_public_assets, 'public');
        $this->publishes($xylophone_custom_routes_file, 'custom_routes');
        $this->publishes($gravatar_assets, 'gravatar');
        $this->publishes($elfinder_files, 'elfinder');
        $this->publishes($minimum, 'minimum');
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/xylophone, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    /**
     * Load custom routes file.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupCustomRoutes(Router $router)
    {
        // if the custom routes file is published, register its routes
        if (file_exists(base_path().$this->customRoutesFilePath)) {
            $this->loadRoutesFrom(base_path().$this->customRoutesFilePath);
        }
    }

    /**
     * The route macro allows developers to generate the routes for a CrudController,
     * for all operations, using a simple syntax: Route::crud().
     *
     * It will go to the given CrudController and get the setupRoutes() method on it.
     */
    private function addRouteMacro()
    {
        Route::macro('crud', function ($name, $controller) {
            // put together the route name prefix,
            // as passed to the Route::group() statements
            $routeName = '';
            if ($this->hasGroupStack()) {
                foreach ($this->getGroupStack() as $key => $groupStack) {
                    if (isset($groupStack['name'])) {
                        if (is_array($groupStack['name'])) {
                            $routeName = implode('', $groupStack['name']);
                        } else {
                            $routeName = $groupStack['name'];
                        }
                    }
                }
            }
            // add the name of the current entity to the route name prefix
            // the result will be the current route name (not ending in dot)
            $routeName .= $name;

            // get an instance of the controller
            if ($this->hasGroupStack()) {
                $groupStack = $this->getGroupStack();
                $groupNamespace = $groupStack && isset(end($groupStack)['namespace']) ? end($groupStack)['namespace'].'\\' : 'App\\';
            } else {
                $groupNamespace = '';
            }
            $namespacedController = $groupNamespace.$controller;
            $controllerInstance = new $namespacedController();

            return $controllerInstance->setupRoutes($name, $routeName, $controller);
        });
    }

    public function loadViewsWithFallbacks()
    {
        $customBaseFolder = resource_path('views/vendor/xylophone/base');
        $customCrudFolder = resource_path('views/vendor/xylophone/crud');

        // - first the published/overwritten views (in case they have any changes)
        if (file_exists($customBaseFolder)) {
            $this->loadViewsFrom($customBaseFolder, 'xylophone');
        }
        if (file_exists($customCrudFolder)) {
            $this->loadViewsFrom($customCrudFolder, 'crud');
        }
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/base'), 'xylophone');
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/crud'), 'crud');
    }

    public function loadConfigs()
    {
        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(__DIR__.'/config/xylophone/crud.php', 'xylophone.crud');
        $this->mergeConfigFrom(__DIR__.'/config/xylophone/base.php', 'xylophone.base');

        // add the root disk to filesystem configuration
        app()->config['filesystems.disks.'.config('xylophone.base.root_disk_name')] = [
            'driver' => 'local',
            'root'   => base_path(),
        ];

        /*
         * Xylophone login differs from the standard Laravel login.
         * As such, Xylophone uses its own authentication provider, password broker and guard.
         *
         * THe process below adds those configuration values on top of whatever is in config/auth.php.
         * Developers can overwrite the xylophone provider, password broker or guard by adding a
         * provider/broker/guard with the "xylophone" name inside their config/auth.php file.
         * Or they can use another provider/broker/guard entirely, by changing the corresponding
         * value inside config/xylophone/base.php
         */

        // add the xylophone_users authentication provider to the configuration
        app()->config['auth.providers'] = app()->config['auth.providers'] +
        [
            'xylophone' => [
                'driver'  => 'eloquent',
                'model'   => config('xylophone.base.user_model_fqn'),
            ],
        ];

        // add the xylophone_users password broker to the configuration
        app()->config['auth.passwords'] = app()->config['auth.passwords'] +
        [
            'xylophone' => [
                'provider'  => 'xylophone',
                'table'     => 'password_resets',
                'expire'    => 60,
            ],
        ];

        // add the xylophone_users guard to the configuration
        app()->config['auth.guards'] = app()->config['auth.guards'] +
        [
            'xylophone' => [
                'driver'   => 'session',
                'provider' => 'xylophone',
            ],
        ];
    }

    /**
     * Load the Xylophone helper methods, for convenience.
     */
    public function loadHelpers()
    {
        require_once __DIR__.'/helpers.php';
    }
}
