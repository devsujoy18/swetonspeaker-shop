<?php

use App\Livewire\Admin\SeoMetaComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\SeoMeta;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
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
});

test('admin can save seo data for a selected page', function (): void {
    Livewire::test(SeoMetaComponent::class)
        ->set('targetType', SeoMetaComponent::TargetStaticPage)
        ->set('targetValue', 'home')
        ->set('title', 'Home SEO Title')
        ->set('keywords', 'speaker, sweton')
        ->set('description', 'Shop home SEO description')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('modalOpen', false);

    $seoMeta = SeoMeta::first();

    expect($seoMeta)->not->toBeNull()
        ->and($seoMeta->type)->toBe(SeoMeta::TypeShopSite)
        ->and($seoMeta->route_name)->toBe('home')
        ->and($seoMeta->title)->toBe('Home SEO Title')
        ->and($seoMeta->is_active)->toBeTrue();
});

test('admin can save seo data for a selected category', function (): void {
    $category = Category::forceCreate([
        'name' => 'Woofers',
        'slug' => 'woofers',
    ]);

    Livewire::test(SeoMetaComponent::class)
        ->set('targetType', SeoMetaComponent::TargetCategory)
        ->set('targetValue', (string) $category->id)
        ->set('title', 'Woofers SEO Title')
        ->call('save')
        ->assertHasNoErrors();

    $seoMeta = SeoMeta::first();

    expect($seoMeta)->not->toBeNull()
        ->and($seoMeta->type)->toBe(SeoMeta::TypeShopSite)
        ->and($seoMeta->page_type)->toBe(SeoMeta::PageTypeCategory)
        ->and($seoMeta->entity_type)->toBe(Category::class)
        ->and($seoMeta->entity_id)->toBe($category->id)
        ->and($seoMeta->slug)->toBe('woofers');
});

test('admin can save seo data when selected product value is numeric', function (): void {
    $product = Product::forceCreate([
        'name' => '10 IT 400 MID',
        'slug' => '10-it-400-mid',
    ]);

    Livewire::test(SeoMetaComponent::class)
        ->set('targetType', SeoMetaComponent::TargetProduct)
        ->set('targetValue', $product->id)
        ->set('title', '10 IT 400 MID')
        ->set('keywords', '10 IT 400 MID')
        ->set('description', '10 IT 400 MID')
        ->call('save')
        ->assertHasNoErrors();

    $seoMeta = SeoMeta::first();

    expect($seoMeta)->not->toBeNull()
        ->and($seoMeta->page_type)->toBe(SeoMeta::PageTypeProduct)
        ->and($seoMeta->entity_type)->toBe(Product::class)
        ->and($seoMeta->entity_id)->toBe($product->id);
});

test('product dropdown displays decoded product names', function (): void {
    Product::forceCreate([
        'name' => 'SPEAKER 4â€ 6 WT - AMPLI',
        'slug' => 'speaker-4-6-wt-ampli',
    ]);

    Livewire::test(SeoMetaComponent::class)
        ->call('openCreateModal')
        ->set('targetType', SeoMetaComponent::TargetProduct)
        ->assertSee('SPEAKER 4&quot; 6 WT - AMPLI', false);
});

test('admin can toggle seo data status', function (): void {
    $seoMeta = SeoMeta::create([
        'route_name' => 'cart',
        'title' => 'Cart SEO Title',
    ]);

    Livewire::test(SeoMetaComponent::class)
        ->call('toggleStatus', $seoMeta->id);

    expect($seoMeta->refresh()->is_active)->toBeFalse();
});
