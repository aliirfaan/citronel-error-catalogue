<?php

namespace aliirfaan\CitronelErrorCatalogue;

use aliirfaan\CitronelErrorCatalogue\Console\Commands\DumpErrorCatalogue;
use aliirfaan\CitronelErrorCatalogue\Console\Commands\DumpLangMessages;

class CitronelErrorCatalogueProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/citronel-error-catalogue.php', 'citronel-error-catalogue'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../config/citronel-error-config.php', 'citronel-error-config'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../config/citronel-general-error-catalogue.php', 'citronel-general-error-catalogue'
        );
    }
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/citronel-error-catalogue.php' => config_path('citronel-error-catalogue.php'),
            __DIR__.'/../config/citronel-error-config.php' => config_path('citronel-error-config.php'),
            __DIR__.'/../config/citronel-general-error-catalogue.php' => config_path('citronel-general-error-catalogue.php'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'citronel-error-catalogue');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DumpErrorCatalogue::class,
                DumpLangMessages::class,
            ]);
        }
    }
}
