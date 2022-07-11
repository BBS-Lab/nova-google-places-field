<?php

namespace BBSLab\NovaGooglePlacesField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-google-places-field', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-google-places-field', __DIR__.'/../dist/css/field.css');

            $url = str_replace(
                ':YOUR_API_KEY',
                config('nova-google-places.api_key'),
                config('nova-google-places.script_url')
            );

            Nova::remoteScript($url);
        });

        $this->publishes([
            __DIR__.'/../config/nova-google-places.php' => config_path('nova-google-places.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nova-google-places.php', 'nova-google-places'
        );
    }
}
