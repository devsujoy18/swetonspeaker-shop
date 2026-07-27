<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\SeoMeta;
use App\Services\SeoMetaResolver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    config()->set('database.default', 'sqlite');
    config()->set('database.connections.sqlite.database', ':memory:');

    DB::purge('sqlite');
    DB::reconnect('sqlite');

    Schema::dropIfExists('seo_metas');
    Schema::dropIfExists('products');
    Schema::dropIfExists('categories');

    Schema::create('seo_metas', function (Blueprint $table): void {
        $table->id();
        $table->string('type', 30)->default('shop_site');
        $table->string('page_type', 50)->default('page');
        $table->string('route_name')->nullable();
        $table->string('path')->nullable();
        $table->string('entity_type')->nullable();
        $table->unsignedBigInteger('entity_id')->nullable();
        $table->string('slug')->nullable();
        $table->string('title');
        $table->text('keywords')->nullable();
        $table->text('description')->nullable();
        $table->string('canonical_url')->nullable();
        $table->string('robots')->default('index, follow');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    Schema::create('categories', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->string('slug')->nullable();
        $table->timestamps();
    });

    Schema::create('products', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->string('slug')->nullable();
        $table->foreignId('category_id')->nullable();
        $table->timestamps();
    });

    Route::get('/seo-test-home', fn () => 'home')->name('seo.test.home');
    Route::get('/seo-test/{type}/{categorySlug}', fn () => 'category')->name('category.products');
    Route::get('/seo-test/{type}/{categorySlug}/{productSlug}', fn () => 'product')->name('product.details');
});

test('it resolves route seo before default seo', function (): void {
    SeoMeta::create([
        'page_type' => SeoMeta::PageTypeDefault,
        'title' => 'Default SEO title',
    ]);

    SeoMeta::create([
        'route_name' => 'seo.test.home',
        'title' => 'Home SEO title',
        'keywords' => 'speaker, audio',
        'description' => 'Home SEO description',
    ]);

    $request = request()->create('/seo-test-home');
    $request->setRouteResolver(fn () => Route::getRoutes()->match($request));

    $seoMeta = app(SeoMetaResolver::class)->resolve($request);

    expect($seoMeta['title'])->toBe('Home SEO title')
        ->and($seoMeta['keywords'])->toBe('speaker, audio')
        ->and($seoMeta['description'])->toBe('Home SEO description');
});

test('it resolves product seo by entity before slug and default seo', function (): void {
    $category = Category::forceCreate([
        'name' => 'Woofers',
        'slug' => 'woofers',
    ]);

    $product = Product::forceCreate([
        'name' => 'Sweton Woofer',
        'slug' => 'sweton-woofer',
        'category_id' => $category->id,
    ]);

    SeoMeta::create([
        'page_type' => SeoMeta::PageTypeDefault,
        'title' => 'Default SEO title',
    ]);

    SeoMeta::create([
        'page_type' => SeoMeta::PageTypeProduct,
        'slug' => 'sweton-woofer',
        'title' => 'Slug Product SEO title',
    ]);

    SeoMeta::create([
        'page_type' => SeoMeta::PageTypeProduct,
        'entity_type' => Product::class,
        'entity_id' => $product->id,
        'title' => 'Entity Product SEO title',
    ]);

    $request = request()->create('/seo-test/pro-loudspeaker/woofers/sweton-woofer');
    $request->setRouteResolver(fn () => Route::getRoutes()->match($request));

    $seoMeta = app(SeoMetaResolver::class)->resolve($request);

    expect($seoMeta['title'])->toBe('Entity Product SEO title');
});

test('it falls back to default seo when specific seo is missing', function (): void {
    SeoMeta::create([
        'page_type' => SeoMeta::PageTypeDefault,
        'title' => 'Default SEO title',
        'description' => 'Default SEO description',
    ]);

    $request = request()->create('/unknown-public-page');
    $request->setRouteResolver(fn () => null);

    $seoMeta = app(SeoMetaResolver::class)->resolve($request);

    expect($seoMeta['title'])->toBe('Default SEO title')
        ->and($seoMeta['description'])->toBe('Default SEO description');
});
