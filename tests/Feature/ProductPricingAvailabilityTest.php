<?php

use App\Livewire\Products\PublicDetailsComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPriceAttribute;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(DatabaseTransactions::class);

beforeEach(function (): void {
    Cart::clear();
});

afterEach(function (): void {
    Cart::clear();
});

function createProductPricingFixture(float $basePrice, array $attributePrices = []): array
{
    $category = Category::unguarded(function () {
        return Category::create([
            'name' => 'Pricing Category '.Str::uuid(),
            'slug' => Str::uuid()->toString(),
            'type_id' => 1,
            'image' => null,
            'order_no' => 0,
            'status' => 0,
            'show_on_home' => 0,
            'shop_status' => 0,
            'shop_order_no' => 0,
            'shop_show_on_home' => 0,
        ]);
    });

    $product = Product::unguarded(function () use ($basePrice, $category) {
        return Product::create([
            'name' => 'Pricing Product '.Str::uuid(),
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
            'mrp' => $basePrice + 100,
            'price' => $basePrice,
            'shop_status' => 0,
            'shop_order_no' => 0,
            'shop_description' => null,
        ]);
    });

    foreach ($attributePrices as $index => $attributePrice) {
        ProductPriceAttribute::create([
            'product_id' => $product->id,
            'name' => 'Option '.($index + 1),
            'mrp' => $attributePrice + 100,
            'price' => $attributePrice,
        ]);
    }

    return [
        $product->fresh()->load('priceAttributes'),
        $category,
    ];
}

test('product helpers only treat positive prices as purchasable', function (): void {
    [$product] = createProductPricingFixture(0, [0, 1499]);

    expect($product->hasPurchasableBasePrice())->toBeFalse()
        ->and($product->hasPurchasablePriceAttributes())->toBeTrue()
        ->and($product->validPriceAttributes())->toHaveCount(1)
        ->and((float) $product->validPriceAttributes()->first()->price)->toBe(1499.0);
});

test('product details blocks products without any purchasable price', function (): void {
    [$product, $category] = createProductPricingFixture(0);

    Livewire::test(PublicDetailsComponent::class, [
        'type' => 'pro-loudspeaker',
        'categorySlug' => $category->slug,
        'productSlug' => $product->slug,
    ])
        ->call('addToCart')
        ->assertHasNoErrors();

    expect(Cart::getContent())->toHaveCount(0);
});

test('product details blocks zero-priced attributes from being added to cart', function (): void {
    [$product, $category] = createProductPricingFixture(0, [0, 1499]);
    $zeroPricedAttribute = $product->priceAttributes->first(function (ProductPriceAttribute $attribute): bool {
        return (float) $attribute->price === 0.0;
    });

    Livewire::test(PublicDetailsComponent::class, [
        'type' => 'pro-loudspeaker',
        'categorySlug' => $category->slug,
        'productSlug' => $product->slug,
    ])
        ->set('selectedAttributeId', $zeroPricedAttribute->id)
        ->call('addToCart')
        ->assertHasNoErrors();

    expect(Cart::getContent())->toHaveCount(0);
});

test('product details still adds a valid priced attribute to cart', function (): void {
    [$product, $category] = createProductPricingFixture(0, [0, 1499]);
    $validAttribute = $product->priceAttributes->first(function (ProductPriceAttribute $attribute): bool {
        return (float) $attribute->price === 1499.0;
    });

    Livewire::test(PublicDetailsComponent::class, [
        'type' => 'pro-loudspeaker',
        'categorySlug' => $category->slug,
        'productSlug' => $product->slug,
    ])
        ->set('selectedAttributeId', $validAttribute->id)
        ->call('addToCart')
        ->assertHasNoErrors();

    $cartItem = Cart::getContent()->first();

    expect(Cart::getContent())->toHaveCount(1)
        ->and($cartItem->name)->toContain($product->name)
        ->and($cartItem->price)->toBe(1499.0);
});
