<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(255);
        Validator::extend('valid_quality_ranks', function ($key, $value) {
            $qualityRanks = array_keys(Controller::QUALITY_RANKS);
            $requestRanks = explode(',', $value);
            foreach ($requestRanks as $rank) {
                if (!in_array($rank, $qualityRanks)) {
                    return false;
                }
            }
            return true;
        }, 'The :attribute contains invalid ranks');
    }
}
