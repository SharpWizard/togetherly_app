<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // The UI is Bootstrap 5; use Bootstrap pagination instead of Laravel's
        // default Tailwind paginator (whose unstyled SVG arrows render huge).
        Paginator::useBootstrapFive();

        // Behind Railway's TLS-terminating proxy the app is served over HTTPS.
        // Force the https scheme so every route()/url()/asset() and form action
        // is generated as https (prevents "form is not secure" browser warnings).
        if ($this->app->environment('production') || str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
