<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\{
    Ad,
    AdCategory
};
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AdCategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('adCategories', function ($app) {
            $tableExists = Schema::hasTable('ad_categories');

            if ($tableExists) {
                return AdCategory::where('status', 1)
                ->with(['ads' => function($query) {
                    $query->orderBy('order_by', 'asc');
                }])
                ->get();
            }

            return collect();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('adCategories', $this->app->make('adCategories'));

    }
}
