<?php

namespace aliirfaan\CitronelErrorCatalogue;

use aliirfaan\CitronelErrorCatalogue\Console\Commands\DumpErrorCatalogue;
use aliirfaan\CitronelErrorCatalogue\Console\Commands\DumpLangMessages;

class CitronelErrorCatalogueProvider extends \Illuminate\Support\ServiceProvider
{
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
