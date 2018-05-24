<?php
namespace Emimaster16\Autorizacion;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Blade;

/**
 *
 * @tutorial Working Class
 * @author Eminson Mendoza ~~ emimaster16@gmail.com
 * @since {24/05/2018}
 */
class AutorizacionServiceProvider extends ServiceProvider
{

    /**
     * Indicates of loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     *
     * @return null
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/autorizacion.php' => config_path('autorizacion.php')
        ]);
        
        if (version_compare(Application::VERSION, '5.3.0', '<')) {
            $this->publishes([
                __DIR__ . '/../migrations' => $this->app->databasePath() . '/migrations'
            ], 'migrations');
        } else {
            if (config('autorizacion.run-migrations', true)) {
                $this->loadMigrationsFrom(__DIR__ . '/../migrations');
            }
        }
        
        $this->registerBladeDirectives();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/autorizacion.php', 'autorizacion');
        
        $this->app->singleton('autorizacion', function ($app)
        {
            $auth = $app->make('Illuminate\Contracts\Auth\Guard');
            
            return new AutorizacionAutorizacion($auth);
        });
    }

    /**
     * Register the blade directives.
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        Blade::directive('can', function ($expression)
        {
            return "<?php if (\\Autorizacion::can({$expression})): ?>";
        });
        
        Blade::directive('endcan', function ($expression)
        {
            return '<?php endif; ?>';
        });
        
        Blade::directive('canatleast', function ($expression)
        {
            return "<?php if (\\Autorizacion::canAtLeast({$expression})): ?>";
        });
        
        Blade::directive('endcanatleast', function ($expression)
        {
            return '<?php endif; ?>';
        });
        
        Blade::directive('perfil', function ($expression)
        {
            return "<?php if (\\Autorizacion::isPerfil({$expression})): ?>";
        });
        
        Blade::directive('endperfil', function ($expression)
        {
            return '<?php endif; ?>';
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'autorizacion'
        ];
    }
}
