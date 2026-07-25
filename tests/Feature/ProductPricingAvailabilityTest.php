<?php

use App\Livewire\Cart\IconComponent;
use App\Livewire\Category\CategoryProductsComponent;
use App\Livewire\Category\TypeProductComponent;
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
        ->assertHasNoErrors()
        ->assertDispatched('cart-qty-changed-mobile', function (string $event, array $params): bool {
            return $params['currentQuantity'] === 1;
        });

    $cartItem = Cart::getContent()->first();

    expect(Cart::getContent())->toHaveCount(1)
        ->and($cartItem->name)->toContain($product->name)
        ->and($cartItem->price)->toBe(1499.0);
});

test('category product list add to cart dispatches client side cart count update', function (): void {
    [$product, $category] = createProductPricingFixture(995);

    Livewire::test(CategoryProductsComponent::class, [
        'type' => 'pro-loudspeaker',
        'categorySlug' => $category->slug,
    ])
        ->call('addTocart', $product->id)
        ->assertHasNoErrors()
        ->assertDispatched('cart-qty-changed-mobile', function (string $event, array $params): bool {
            return $params['currentQuantity'] === 1;
        });

    expect(Cart::getTotalQuantity())->toBe(1);
});

test('category attribute modal add to cart dispatches the updated cart count', function (): void {
    [$product, $category] = createProductPricingFixture(0, [1499]);
    $validAttribute = $product->priceAttributes->first();

    Livewire::test(CategoryProductsComponent::class, [
        'type' => 'pro-loudspeaker',
        'categorySlug' => $category->slug,
    ])
        ->call('openAttributeModal', $product->id, 'add-to-cart')
        ->set('selectedAttributeId', $validAttribute->id)
        ->call('confirmAction')
        ->assertHasNoErrors()
        ->assertDispatched('cart-qty-changed-mobile', function (string $event, array $params): bool {
            return $params['currentQuantity'] === 1;
        });

    expect(Cart::getTotalQuantity())->toBe(1);
});

test('type product list add to cart dispatches the updated cart count', function (): void {
    [$product] = createProductPricingFixture(995);

    Livewire::test(TypeProductComponent::class, [
        'type' => 'pro-loudspeaker',
    ])
        ->call('addTocart', $product->id)
        ->assertHasNoErrors()
        ->assertDispatched('cart-qty-changed-mobile', function (string $event, array $params): bool {
            return $params['currentQuantity'] === 1;
        });

    expect(Cart::getTotalQuantity())->toBe(1);
});

test('cart icon refreshes dropdown contents after cart quantity update event', function (): void {
    [$product] = createProductPricingFixture(995);

    $cartIcon = Livewire::test(IconComponent::class)
        ->assertSee('Your cart is empty.');

    Cart::add([
        'id' => $product->id,
        'name' => $product->name,
        'price' => 995,
        'quantity' => 1,
        'attributes' => [
            'mrp' => 1095,
            'image' => asset('image/buy.jpg'),
            'shop_description' => null,
            'product_id' => $product->id,
            'price_attribute_id' => null,
            'attribute_name' => null,
        ],
    ]);

    $cartIcon
        ->call('refreshCart')
        ->assertSee($product->name)
        ->assertDontSee('Your cart is empty.');
});
