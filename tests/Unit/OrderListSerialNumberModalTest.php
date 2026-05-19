<?php

use App\Livewire\Admin\OrderList;
use App\Models\Order;
use App\Models\User;
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
