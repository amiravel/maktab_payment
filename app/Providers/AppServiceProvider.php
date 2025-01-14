<?php

namespace App\Providers;

use App\Models\Cycle;
use App\Models\Payment;
use App\Observers\CycleObserver;
use App\Observers\PaymentObserver;
use Illuminate\Support\ServiceProvider;

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
        Payment::observe(PaymentObserver::class);
        Cycle::observe(CycleObserver::class);

        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
