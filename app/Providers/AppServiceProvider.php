<?php

namespace StockAnalysis\Providers;

use Illuminate\Support\ServiceProvider;
use StockAnalysis\Services\StockBuySell;
use StockAnalysis\Services\StockService;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('key', 'value');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            StockService::class
        );

//        $this->app->singleton(StockBuySell::class, function ($app) {
//            return new StockBuySell($app);
//        });
    }
}
