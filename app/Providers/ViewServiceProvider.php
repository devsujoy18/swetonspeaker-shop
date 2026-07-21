<?php

namespace App\Providers;

use App\Services\CategoryService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Bind the CategoryService to the container (optional, but good practice)
        $this->app->singleton(CategoryService::class, function ($app) {
            return new CategoryService;
        });

        View::composer(['components.frontend.header', 'components.frontend.navbar'], function ($view) {
            $categoryService = app(CategoryService::class);
            $sellableCategories = $categoryService->getSellableCategoriesGroupedByType();
            $view->with('proCategories', $sellableCategories['pro']);
            $view->with('homeCategories', $sellableCategories['home']);
        });
    }
}
