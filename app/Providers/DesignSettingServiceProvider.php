<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\DesignSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class DesignSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('designSetting', function ($app) {
            $tableExists = Schema::hasTable('design_settings');

            if ($tableExists) {
                return DesignSetting::first();
            }

            return collect();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('designSetting', $this->app->make('designSetting'));

    }
}
