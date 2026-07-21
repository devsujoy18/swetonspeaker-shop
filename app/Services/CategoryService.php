<?php

namespace App\Services;

use App\Models\Category;
use ErrorException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    private const SELLABLE_CATEGORIES_BY_TYPE_KEY = 'sellable_categories_by_type';

    /**
     * Get sellable categories, categorized by type, with caching.
     */
    public function getSellableCategoriesGroupedByType(): array
    {
        return once(function (): array {
            $categories = $this->rememberArray(self::SELLABLE_CATEGORIES_BY_TYPE_KEY, now()->addHours(24), function (): array {
                return Category::query()
                    ->select(['id', 'name', 'slug', 'type_id', 'shop_order_no'])
                    ->with([
                        'products' => function ($query): void {
                            $query
                                ->select(['id', 'category_id', 'name', 'slug', 'shop_order_no'])
                                ->where('is_sealable', 1)
                                ->where('shop_status', 0)
                                ->orderBy('shop_order_no');
                        },
                    ])
                    ->whereHas('products', function ($query): void {
                        $query
                            ->where('is_sealable', 1)
                            ->where('shop_status', 0);
                    })
                    ->where('shop_status', 0)
                    ->orderBy('shop_order_no')
                    ->get()
                    ->map(function (Category $category): array {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'type_id' => $category->type_id,
                            'products' => $category->products
                                ->map(fn ($product): array => [
                                    'id' => $product->id,
                                    'category_id' => $product->category_id,
                                    'name' => $product->name,
                                    'slug' => $product->slug,
                                ])
                                ->all(),
                        ];
                    })
                    ->all();
            });

            return $this->groupCategoriesForNavigation($categories);
        });
    }

    /**
     * Clear the sellable categories cache.
     * Call this method whenever categories or products are updated/deleted.
     */
    public function clearSellableCategoriesGroupedByType(): void
    {
        Cache::forget(self::SELLABLE_CATEGORIES_BY_TYPE_KEY);
    }

    /**
     * Method : getSellableCategoriesforhome
     * Description : Get Sellable categories for home page
     *
     * @return : Array
     **/
    public function getSellableCategoriesforhome()
    {
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
     *
     * @return : Array
     **/
    public function clearSellableCategoriesforhome()
    {
        Cache::forget('sellable_categories_for_home');
    }

    /**
     * Method : getCategoryWithProducts
     * Description : Get specific categories products
     *
     * @param : $slug
     * @return : Collection
     */
    public function getCategoryWithProducts(string $slug): Category
    {
        $cacheKey = "category_with_products_{$slug}";

        return Cache::remember($cacheKey, now()->addHours(12), function () use ($slug) {
            return Category::select(['id', 'name', 'slug', 'type_id', 'shop_status'])
                ->where('slug', $slug)
                ->where('shop_status', 0)
                ->firstOrFail();
        });
    }

    public function clearCategoryWithProducts(string $slug): void
    {
        Cache::forget("category_with_products_{$slug}");
    }

    /**
     * @param  callable(): array  $callback
     */
    private function rememberArray(string $key, mixed $ttl, callable $callback): array
    {
        try {
            $cachedValue = Cache::get($key);

            if (is_array($cachedValue)) {
                return $cachedValue;
            }
        } catch (ErrorException) {
            Cache::forget($key);
        }

        $value = $callback();

        Cache::put($key, $value, $ttl);

        return $value;
    }

    /**
     * @param  array<int, array{id: int, name: string, slug: string, type_id: int, products: array<int, array{id: int, category_id: int, name: string, slug: string}>}>  $categories
     * @return array{pro: Collection<int, object>, home: Collection<int, object>}
     */
    private function groupCategoriesForNavigation(array $categories): array
    {
        $groupedCategories = [
            'pro' => collect(),
            'home' => collect(),
        ];

        foreach ($categories as $category) {
            $navigationCategory = (object) [
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => $category['slug'],
                'type_id' => $category['type_id'],
                'products' => collect($category['products'])
                    ->map(fn (array $product): object => (object) $product),
            ];

            if ($navigationCategory->type_id === 1) {
                $groupedCategories['pro']->push($navigationCategory);
            } elseif ($navigationCategory->type_id === 2) {
                $groupedCategories['home']->push($navigationCategory);
            }
        }

        return $groupedCategories;
    }
}
