<?php

use App\Livewire\Admin\OrderList;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    config()->set('database.default', 'sqlite');
    config()->set('database.connections.sqlite.database', ':memory:');

    DB::purge('sqlite');
    DB::reconnect('sqlite');

    Schema::dropIfExists('order_items');
    Schema::dropIfExists('orders');
    Schema::dropIfExists('users');
    Schema::dropIfExists('notifications');

    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->string('user_type')->default('user');
        $table->timestamps();
    });

    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_number')->unique();
        $table->foreignId('user_id')->nullable();
        $table->string('billing_name')->nullable();
        $table->string('billing_email')->nullable();
        $table->string('billing_phone')->nullable();
        $table->decimal('subtotal', 10, 2)->default(0);
        $table->decimal('total', 10, 2)->default(0);
        $table->decimal('refunded_amount', 10, 2)->default(0);
        $table->string('payment_status')->default('processing');
        $table->string('order_status')->default('processing');
        $table->timestamp('order_date')->nullable();
        $table->integer('order_sl_no')->default(0);
        $table->text('token')->nullable();
        $table->string('awb_partner')->nullable();
        $table->text('awb_number')->nullable();
        $table->boolean('is_modified')->default(false);
        $table->timestamps();
    });

    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->nullable();
        $table->foreignId('product_id')->nullable();
        $table->timestamps();
    });

    Schema::create('notifications', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('type');
        $table->morphs('notifiable');
        $table->text('data');
        $table->timestamp('read_at')->nullable();
        $table->timestamps();
    });
});

test('admin can update order serial number through modal for successful payment orders', function () {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    $order = Order::create([
        'payment_status' => 'success',
        'order_status' => 'confirmed',
        'order_sl_no' => 0,
    ]);

    $this->actingAs($admin);

    Livewire::test(OrderList::class)
        ->call('openOrderSlNoModal', $order->id)
        ->assertSet('orderSlNoModalOpen', true)
        ->set('orderSlNo', 17)
        ->call('saveOrderSlNo')
        ->assertHasNoErrors('orderSlNo')
        ->assertSet('orderSlNoModalOpen', false);

    expect($order->refresh()->order_sl_no)->toBe(17);
});

test('order serial number cannot be updated when payment status is not success', function () {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    $order = Order::create([
        'payment_status' => 'processing',
        'order_status' => 'processing',
        'order_sl_no' => 0,
    ]);

    $this->actingAs($admin);

    Livewire::test(OrderList::class)
        ->set('selectedOrderSlNoId', $order->id)
        ->set('orderSlNo', 9)
        ->call('saveOrderSlNo');

    expect($order->refresh()->order_sl_no)->toBe(0);
});

test('admin can refund a cancelled paid order from the payment status column', function () {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    $order = Order::create([
        'billing_name' => 'Refund Customer',
        'billing_email' => 'refund@example.com',
        'billing_phone' => '9999999999',
        'total' => 499.00,
        'payment_status' => 'success',
        'order_status' => 'cancelled',
    ]);

    $this->actingAs($admin);

    Livewire::test(OrderList::class)
        ->assertSee('Refund')
        ->call('updatePaymentStatus', $order->id, 'refunded');

    expect($order->refresh()->payment_status)->toBe('refunded');
    expect((float) $order->refresh()->refunded_amount)->toBe(499.0);

    Livewire::test(OrderList::class)
        ->call('updatePaymentStatus', $order->id, 'refunded', 100);

    expect((float) $order->refresh()->refunded_amount)->toBe(499.0);
});

test('admin can record a refund amount for a cancelled paid order', function () {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    $order = Order::create([
        'billing_name' => 'Refund Amount Customer',
        'billing_email' => 'partial@example.com',
        'billing_phone' => '9999999995',
        'total' => 1024.00,
        'payment_status' => 'success',
        'order_status' => 'cancelled',
    ]);

    $this->actingAs($admin);

    Livewire::test(OrderList::class)
        ->call('openRefundModal', $order->id)
        ->assertSet('refundModalOpen', true)
        ->set('refundAmount', 524)
        ->call('saveRefund')
        ->assertHasNoErrors('refundAmount')
        ->assertSet('refundModalOpen', false);

    expect($order->refresh()->payment_status)->toBe('refunded');
    expect((float) $order->refresh()->refunded_amount)->toBe(524.0);
});

test('dashboard revenue counts net refunded amounts', function () {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    Order::create([
        'billing_name' => 'Successful Order',
        'billing_email' => 'success@example.com',
        'billing_phone' => '9999999998',
        'total' => 120.00,
        'payment_status' => 'success',
        'order_status' => 'confirmed',
    ]);

    Order::create([
        'billing_name' => 'Cancelled Order',
        'billing_email' => 'cancelled@example.com',
        'billing_phone' => '9999999997',
        'total' => 80.00,
        'payment_status' => 'success',
        'order_status' => 'cancelled',
    ]);

    Order::create([
        'billing_name' => 'Refunded Order',
        'billing_email' => 'refunded@example.com',
        'billing_phone' => '9999999996',
        'total' => 60.00,
        'refunded_amount' => 60.00,
        'payment_status' => 'refunded',
        'order_status' => 'cancelled',
    ]);

    Order::create([
        'billing_name' => 'Refunded Amount Order',
        'billing_email' => 'partial-refunded@example.com',
        'billing_phone' => '9999999995',
        'total' => 100.00,
        'refunded_amount' => 24.00,
        'payment_status' => 'refunded',
        'order_status' => 'cancelled',
    ]);

    $response = $this->actingAs($admin)->get(route('dashboard'));

    $response->assertOk();

    expect((float) $response->viewData('totalRevenue'))->toBe(196.0);
});

test('dashboard charts only count orders and revenue on their matching day', function () {
    Carbon::setTestNow(Carbon::parse('2026-05-28 12:00:00'));

    try {
        $admin = User::factory()->create([
            'user_type' => 'admin',
        ]);

        $dayOneOrder = Order::create([
            'billing_name' => 'Day One Success',
            'billing_email' => 'day-one@example.com',
            'billing_phone' => '9999999994',
            'total' => 100.00,
            'payment_status' => 'success',
            'order_status' => 'confirmed',
        ]);

        $dayOneOrder->forceFill([
            'order_date' => Carbon::parse('2026-05-22'),
        ])->saveQuietly();

        $daySevenOrder = Order::create([
            'billing_name' => 'Day Seven Refunded',
            'billing_email' => 'day-seven@example.com',
            'billing_phone' => '9999999993',
            'total' => 75.00,
            'refunded_amount' => 25.00,
            'payment_status' => 'refunded',
            'order_status' => 'cancelled',
        ]);

        $daySevenOrder->forceFill([
            'order_date' => Carbon::parse('2026-05-28'),
        ])->saveQuietly();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk();

        expect($response->viewData('ordersData')->all())->toBe([1, 0, 0, 0, 0, 0, 1]);
        expect($response->viewData('revenueData')->all())->toBe([100.0, 0, 0, 0, 0, 0, 50.0]);
    } finally {
        Carbon::setTestNow();
    }
});
