<?php

use App\Livewire\Cart\DetailsComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\CategoryService;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(DatabaseTransactions::class);

beforeEach(function (): void {
    Cache::clear();
    Cart::clear();
});

afterEach(function (): void {
    Cache::clear();
    Cart::clear();
});

function createPublicRouteCategoryFixture(int $typeId = 1): array
{
    $category = Category::unguarded(function () use ($typeId): Category {
        return Category::create([
            'name' => 'Navigation Category '.Str::uuid(),
            'slug' => Str::uuid()->toString(),
            'type_id' => $typeId,
            'image' => null,
            'order_no' => 0,
            'status' => 0,
            'show_on_home' => 0,
            'shop_status' => 0,
            'shop_order_no' => 0,
            'shop_show_on_home' => 0,
        ]);
    });

    $product = Product::unguarded(function () use ($category): Product {
        return Product::create([
            'name' => 'Navigation Product '.Str::uuid(),
            'slug' => Str::uuid()->toString(),
            'category_id' => $category->id,
            'description' => null,
            'order_no' => 0,
            'show_on_home' => 0,
            'is_sealable' => 1,
            'buy_link' => null,
            'drawing' => null,
            'datasheet' => null,
            'status' => 0,
            'mrp' => 1200,
            'price' => 1000,
            'shop_status' => 0,
            'shop_order_no' => 0,
            'shop_description' => null,
        ]);
    });

    return [$category, $product];
}

test('navigation category cache stores lightweight array data', function (): void {
    [$category, $product] = createPublicRouteCategoryFixture();

    $categories = app(CategoryService::class)->getSellableCategoriesGroupedByType();
    $cachedCategories = Cache::get('sellable_categories_by_type');

    expect($categories['pro']->first()->name)->toBe($category->name)
        ->and($categories['pro']->first()->products->first()->name)->toBe($product->name)
        ->and($cachedCategories)->toBeArray()
        ->and($cachedCategories[0])->toHaveKeys(['id', 'name', 'slug', 'type_id', 'products'])
        ->and($cachedCategories[0]['products'][0])->toHaveKeys(['id', 'category_id', 'name', 'slug']);
});

test('cart page validates attribute cart item ids with one product lookup', function (): void {
    [, $product] = createPublicRouteCategoryFixture();

    SiteSetting::unguarded(fn (): SiteSetting => SiteSetting::create([
        'cart_enabled' => true,
        'minimum_cart_amount' => 0,
        'cart_disabled_message' => null,
    ]));

    Cart::add([
        'id' => $product->id.'-99',
        'name' => $product->name,
        'price' => 1000,
        'quantity' => 1,
        'attributes' => [
            'product_id' => $product->id,
            'price_attribute_id' => 99,
        ],
    ]);

    Cart::add([
        'id' => ($product->id + 100000).'-1',
        'name' => 'Removed Product',
        'price' => 1000,
        'quantity' => 1,
        'attributes' => [],
    ]);

    Livewire::test(DetailsComponent::class)
        ->assertHasNoErrors()
        ->assertSee('Updating');

    expect(Cart::getContent()->keys()->all())
        ->toContain($product->id.'-99')
        ->not->toContain(($product->id + 100000).'-1');
});
