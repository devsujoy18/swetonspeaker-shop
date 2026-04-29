<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    /**
     * Get sellable categories, categorized by type, with caching.
     *
     * @return array
     */
    public function getSellableCategoriesGroupedByType(): array
    {
        return Cache::remember('sellable_categories_by_type', now()->addHours(24), function () {
            // Fetch categories that have at least one sellable product
            $categories = Category::with([
                    'products' => function ($query) { // Eager load products
                        $query->where('is_sealable', 1);
                        $query->where('shop_status', 0);
                        $query->orderBy('shop_order_no');
                    }
                ])
                ->whereHas('products', function ($query) {
                    $query->where('is_sealable', 1);
                })
                ->where('shop_status', 0)
                ->orderBy('shop_order_no')
                ->get();

                $groupedCategories = [
                    'pro' => collect(),
                    'home' => collect(),
                ];

                foreach ($categories as $category) {
                    if ($category->type_id === 1) {
                        $groupedCategories['pro']->push($category);
                    } elseif ($category->type_id === 2) {
                        $groupedCategories['home']->push($category);
                    }
                }

            return $groupedCategories;
        });
    }

    /**
     * Clear the sellable categories cache.
     * Call this method whenever categories or products are updated/deleted.
     *
     * @return void
     */
    public function clearSellableCategoriesGroupedByType(): void
    {
        Cache::forget('sellable_categories_by_type');
    }

    /**
     * Method : getSellableCategoriesforhome
     * Description : Get Sellable categories for home page
     * @return : Array
     **/
    public function getSellableCategoriesforhome(){
        return Cache::remember('sellable_categories_for_home', now()->addHours(24), function () {
            $categories = Category::whereHas('products', function ($query) {
                    $query->where('is_sealable', 1);
                })
                ->where('show_on_home', 1)
                ->where('shop_status', 0)
                ->orderBy('shop_order_no')
                ->get();

            $groupedCategories = [
                'pro' => collect(),
                'home' => collect(),
            ];

            foreach ($categories as $category) {
                    if ($category->type_id === 1) {
                        $groupedCategories['pro']->push($category);
                    } elseif ($category->type_id === 2) {
                        $groupedCategories['home']->push($category);
                    }
                }

            return $groupedCategories;
        });
    }

    /**
     * Method : clearSellableCategoriesforhome
     * Description: Clear the sellable categories for home cache. 
     * @return : Array
     **/
    public function clearSellableCategoriesforhome(){
        Cache::forget('sellable_categories_for_home');
    }

    /**
     * Method : getCategoryWithProducts
     * Description : Get specific categories products
     * @param : $slug
     * @return : Collection
     */
    public function getCategoryWithProducts(string $slug): Category
    {
        $cacheKey = "category_with_products_{$slug}";
        
        return Cache::remember($cacheKey, now()->addHours(12), function () use ($slug) {
            return Category::where('slug', $slug)
                ->where('shop_status', 0)
                ->with(['products' => function($query) {
                    $query->where('is_sealable', 1)
                        ->where('shop_status', 0)
                        ->with(['combinations', 'productimages' => function($q) {
                            $q->where('order_no', 1);
                        }])
                        ->orderBy('shop_order_no');
                }])
                ->firstOrFail();
        });
    }

    public function clearCategoryWithProducts(string $slug): void
    {
        Cache::forget("category_with_products_{$slug}");
    }
}