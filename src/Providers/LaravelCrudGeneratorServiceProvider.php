<?php

namespace Dottystyle\LaravelCrudGenerator\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelCrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {        
        /**
         * Commands
         *
         * Uncomment this section to load the commands.
         * A basic command file has already been generated in 'src\Console\Commands\MyPackageCommand.php'.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Dottystyle\LaravelCrudGenerator\Console\Commands\LaravelCrudGeneratorCommand::class,
            ]);
        }

        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
