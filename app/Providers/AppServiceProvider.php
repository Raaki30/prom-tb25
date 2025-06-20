<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Control;
use App\Observers\ControlObserver;
use Illuminate\Support\Facades\URL;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Control::observe(ControlObserver::class);
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        
    }
}
