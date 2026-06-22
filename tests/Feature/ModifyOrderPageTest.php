<?php

use App\Livewire\Admin\EditOrderComponent;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Livewire\Livewire;

test('admin modify order page loads legacy order items without a product id', function (): void {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    $order = Order::create([
        'user_id' => $admin->id,
        'billing_name' => 'Legacy Customer',
        'billing_email' => 'legacy@example.com',
        'billing_phone' => '9876543210',
        'billing_zip' => '123456',
        'billing_locality' => 'Main Road',
        'billing_street' => 'Market Street',
        'billing_city' => 'Mumbai',
        'billing_state' => 'Maharashtra',
        'billing_landmark' => 'Near Station',
        'shipping_same_as_billing' => true,
        'subtotal' => 1250,
        'total' => 1250,
        'payment_method' => 'cod',
        'payment_status' => 'processing',
        'order_status' => 'processing',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => null,
        'price_attribute_id' => null,
        'shop_description' => 'Legacy order item',
        'product_name' => 'Legacy Speaker',
        'quantity' => 1,
        'price' => 1250,
        'total' => 1250,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.orders.modify', $order))
        ->assertOk()
        ->assertSee('Legacy Speaker');
});

test('admin can save a legacy order item without creating duplicates', function (): void {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    $order = Order::create([
        'user_id' => $admin->id,
        'billing_name' => 'Legacy Customer',
        'billing_email' => 'legacy-save@example.com',
        'billing_phone' => '9876543211',
        'billing_zip' => '123456',
        'billing_locality' => 'Main Road',
        'billing_street' => 'Market Street',
        'billing_city' => 'Mumbai',
        'billing_state' => 'Maharashtra',
        'billing_landmark' => 'Near Station',
        'shipping_same_as_billing' => true,
        'subtotal' => 1250,
        'total' => 1250,
        'payment_method' => 'cod',
        'payment_status' => 'processing',
        'order_status' => 'processing',
    ]);

    $legacyItem = OrderItem::create([
        'order_id' => $order->id,
        'product_id' => null,
        'price_attribute_id' => null,
        'shop_description' => 'Legacy order item',
        'product_name' => 'Legacy Speaker',
        'quantity' => 1,
        'price' => 1250,
        'total' => 1250,
    ]);

    $this->actingAs($admin);

    Livewire::test(EditOrderComponent::class, ['order' => $order])
        ->call('saveChanges')
        ->assertHasNoErrors();

    expect(OrderItem::where('order_id', $order->id)->count())->toBe(1);
    expect($legacyItem->refresh()->product_id)->toBeNull();
});
