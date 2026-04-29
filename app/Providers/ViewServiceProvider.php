<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CategoryService;
use Illuminate\Support\Facades\View;

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
            return new CategoryService();
        });

        View::composer('components.frontend.header', function ($view) {
            $categoryService = app(CategoryService::class);
            $sellableCategories = $categoryService->getSellableCategoriesGroupedByType();
            $view->with('proCategories', $sellableCategories['pro']);
            $view->with('homeCategories', $sellableCategories['home']);
        });

        View::composer('components.frontend.navbar', function ($view) {
            $categoryService = app(CategoryService::class);
            $sellableCategories = $categoryService->getSellableCategoriesGroupedByType();
            $view->with('proCategories', $sellableCategories['pro']);
            $view->with('homeCategories', $sellableCategories['home']);
        });
    }
}
