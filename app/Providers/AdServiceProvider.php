<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Ad;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AdServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('ads', function ($app) {
            $tableExists = Schema::hasTable('ads');

            if ($tableExists) {
                return Ad::orderBy('order_by','asc')->get();
            }

            return collect();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('ads', $this->app->make('ads'));

    }
}
