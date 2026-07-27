<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\SeoMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeoMetaResolver
{
    /**
     * @return array{title: string, keywords: string|null, description: string|null, canonical_url: string, robots: string}
     */
    public function resolve(Request $request, string $type = SeoMeta::TypeShopSite): array
    {
        $seoMeta = $this->resolveSpecificSeoMeta($request, $type)
            ?? $this->resolveDefaultSeoMeta($type);

        return [
            'title' => $seoMeta?->title ?: config('app.name', 'Sweton Speaker'),
            'keywords' => $seoMeta?->keywords,
            'description' => $seoMeta?->description,
            'canonical_url' => $seoMeta?->canonical_url ?: $request->url(),
            'robots' => $seoMeta?->robots ?: 'index, follow',
        ];
    }

    protected function resolveSpecificSeoMeta(Request $request, string $type): ?SeoMeta
    {
        $route = $request->route();
        $routeName = $route?->getName();
        $path = '/'.ltrim($request->path(), '/');

        if ($routeName === 'product.details') {
            $productSlug = (string) $route->parameter('productSlug');
            $product = Product::query()
                ->select(['id', 'slug'])
                ->where('slug', $productSlug)
                ->first();

            $productSeoMeta = $product
                ? SeoMeta::query()->active()->forType($type)->forEntity(Product::class, $product->id)->first()
                : null;

            if ($productSeoMeta) {
                return $productSeoMeta;
            }

            $slugSeoMeta = SeoMeta::query()->active()->forType($type)->forPageType(SeoMeta::PageTypeProduct)->forSlug($productSlug)->first();

            if ($slugSeoMeta) {
                return $slugSeoMeta;
            }
        }

        if ($routeName === 'category.products') {
            $categorySlug = (string) $route->parameter('categorySlug');
            $category = Category::query()
                ->select(['id', 'slug'])
                ->where('slug', $categorySlug)
                ->first();

            $categorySeoMeta = $category
                ? SeoMeta::query()->active()->forType($type)->forEntity(Category::class, $category->id)->first()
                : null;

            if ($categorySeoMeta) {
                return $categorySeoMeta;
            }

            $slugSeoMeta = SeoMeta::query()->active()->forType($type)->forPageType(SeoMeta::PageTypeCategory)->forSlug($categorySlug)->first();

            if ($slugSeoMeta) {
                return $slugSeoMeta;
            }
        }

        $pathSeoMeta = SeoMeta::query()
            ->active()
            ->forType($type)
            ->forPath(Str::is('/', $path) ? '/' : $path)
            ->first();

        if ($pathSeoMeta) {
            return $pathSeoMeta;
        }

        if ($routeName) {
            return SeoMeta::query()->active()->forType($type)->forRoute($routeName)->first();
        }

        return null;
    }

    protected function resolveDefaultSeoMeta(string $type): ?SeoMeta
    {
        return SeoMeta::query()
            ->active()
            ->forType($type)
            ->forPageType(SeoMeta::PageTypeDefault)
            ->first();
    }
}
