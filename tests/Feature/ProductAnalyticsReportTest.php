<?php

use App\Http\Requests\ProductAnalyticsRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductPriceAttribute;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

beforeEach(function (): void {
    config()->set('database.default', 'sqlite');
    config()->set('database.connections.sqlite.database', ':memory:');

    DB::purge('sqlite');
    DB::reconnect('sqlite');

    Schema::dropIfExists('order_items');
    Schema::dropIfExists('orders');
    Schema::dropIfExists('product_price_attributes');
    Schema::dropIfExists('products');
    Schema::dropIfExists('users');
    Schema::dropIfExists('notifications');

    Schema::create('users', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->string('user_type')->default('user');
        $table->timestamps();
    });

    Schema::create('products', function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        $table->string('slug')->nullable();
        $table->timestamps();
    });

    Schema::create('product_price_attributes', function (Blueprint $table): void {
        $table->id();
        $table->foreignId('product_id')->nullable();
        $table->string('name');
        $table->decimal('mrp', 10, 2)->nullable();
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });

    Schema::create('orders', function (Blueprint $table): void {
        $table->id();
        $table->string('order_number')->unique();
        $table->foreignId('user_id')->nullable();
        $table->decimal('total', 10, 2)->default(0);
        $table->decimal('refunded_amount', 10, 2)->default(0);
        $table->string('payment_status')->default('processing');
        $table->string('order_status')->default('processing');
        $table->timestamp('order_date')->nullable();
        $table->timestamps();
    });

    Schema::create('order_items', function (Blueprint $table): void {
        $table->id();
        $table->foreignId('order_id')->nullable();
        $table->foreignId('product_id')->nullable();
        $table->foreignId('price_attribute_id')->nullable();
        $table->text('shop_description')->nullable();
        $table->string('product_name')->nullable();
        $table->integer('quantity')->default(0);
        $table->decimal('price', 10, 2)->default(0);
        $table->decimal('total', 10, 2)->default(0);
        $table->timestamps();
    });

    Schema::create('notifications', function (Blueprint $table): void {
        $table->uuid('id')->primary();
        $table->string('type');
        $table->morphs('notifiable');
        $table->text('data');
        $table->timestamp('read_at')->nullable();
        $table->timestamps();
    });
});

test('product analytics summarizes retained sold quantities with date filters', function (): void {
    $admin = User::factory()->create([
        'user_type' => 'admin',
    ]);

    $alpha = Product::unguarded(fn () => Product::create([
        'name' => 'Alpha Speaker',
    ]));

    $beta = Product::unguarded(fn () => Product::create([
        'name' => 'Beta Speaker',
    ]));

    $cancelledOnly = Product::unguarded(fn () => Product::create([
        'name' => 'Cancelled Speaker',
    ]));

    $alphaEightOhm = ProductPriceAttribute::create([
        'product_id' => $alpha->id,
        'name' => '8 Ohm',
        'mrp' => 1200,
        'price' => 1000,
    ]);

    $alphaSixteenOhm = ProductPriceAttribute::create([
        'product_id' => $alpha->id,
        'name' => '16 Ohm',
        'mrp' => 1300,
        'price' => 1100,
    ]);

    $successOrder = Order::create([
        'order_number' => 'SW-ANALYTICS-001',
        'payment_status' => 'success',
        'order_status' => 'confirmed',
        'total' => 3500,
    ]);

    $successOrder->forceFill([
        'order_date' => '2026-06-10 10:00:00',
    ])->saveQuietly();

    OrderItem::create([
        'order_id' => $successOrder->id,
        'product_id' => $alpha->id,
        'price_attribute_id' => $alphaEightOhm->id,
        'product_name' => 'Alpha Speaker (8 Ohm)',
        'quantity' => 2,
        'price' => 1000,
        'total' => 2000,
    ]);

    OrderItem::create([
        'order_id' => $successOrder->id,
        'product_id' => $alpha->id,
        'price_attribute_id' => $alphaSixteenOhm->id,
        'product_name' => 'Alpha Speaker (16 Ohm)',
        'quantity' => 1,
        'price' => 1100,
        'total' => 1100,
    ]);

    OrderItem::create([
        'order_id' => $successOrder->id,
        'product_id' => $beta->id,
        'product_name' => 'Beta Speaker',
        'quantity' => 1,
        'price' => 1500,
        'total' => 1500,
    ]);

    $refundedOrder = Order::create([
        'order_number' => 'SW-ANALYTICS-002',
        'payment_status' => 'refunded',
        'order_status' => 'cancelled',
        'total' => 1000,
        'refunded_amount' => 1000,
    ]);

    $refundedOrder->forceFill([
        'order_date' => '2026-06-12 10:00:00',
    ])->saveQuietly();

    OrderItem::create([
        'order_id' => $refundedOrder->id,
        'product_id' => $alpha->id,
        'price_attribute_id' => $alphaEightOhm->id,
        'product_name' => 'Alpha Speaker (8 Ohm)',
        'quantity' => 1,
        'price' => 1000,
        'total' => 1000,
    ]);

    $cancelledOrder = Order::create([
        'order_number' => 'SW-ANALYTICS-003',
        'payment_status' => 'success',
        'order_status' => 'cancelled',
        'total' => 8000,
    ]);

    $cancelledOrder->forceFill([
        'order_date' => '2026-06-13 10:00:00',
    ])->saveQuietly();

    OrderItem::create([
        'order_id' => $cancelledOrder->id,
        'product_id' => $cancelledOnly->id,
        'product_name' => 'Cancelled Speaker',
        'quantity' => 8,
        'price' => 1000,
        'total' => 8000,
    ]);

    $outsideRangeOrder = Order::create([
        'order_number' => 'SW-ANALYTICS-004',
        'payment_status' => 'success',
        'order_status' => 'confirmed',
        'total' => 5000,
    ]);

    $outsideRangeOrder->forceFill([
        'order_date' => '2026-05-28 10:00:00',
    ])->saveQuietly();

    OrderItem::create([
        'order_id' => $outsideRangeOrder->id,
        'product_id' => $alpha->id,
        'product_name' => 'Alpha Speaker',
        'quantity' => 5,
        'price' => 1000,
        'total' => 5000,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.orders.product-analytics', [
        'from_date' => '2026-06-01',
        'to_date' => '2026-06-30',
    ]));

    $response->assertOk()
        ->assertSee('Product Analytics')
        ->assertSee('Alpha Speaker')
        ->assertSee('8 Ohm')
        ->assertSee('16 Ohm')
        ->assertSee('Beta Speaker')
        ->assertDontSee('Cancelled Speaker');

    $summary = $response->viewData('summary');
    $productReports = $response->viewData('productReports');
    $dailyReports = $response->viewData('dailyReports');

    $alphaEightOhmReport = $productReports->first(function ($report) use ($alphaEightOhm): bool {
        return (int) $report->price_attribute_id === $alphaEightOhm->id;
    });

    $alphaSixteenOhmReport = $productReports->first(function ($report) use ($alphaSixteenOhm): bool {
        return (int) $report->price_attribute_id === $alphaSixteenOhm->id;
    });

    expect($summary['quantity_sold'])->toBe(4)
        ->and($summary['refunded_quantity'])->toBe(1)
        ->and($summary['active_products'])->toBe(3)
        ->and((float) $summary['total_sales'])->toBe(4600.0)
        ->and($summary['top_product_name'])->toBe('Alpha Speaker - 8 Ohm')
        ->and((int) $alphaEightOhmReport->quantity_sold)->toBe(2)
        ->and((int) $alphaEightOhmReport->refunded_quantity)->toBe(1)
        ->and((int) $alphaSixteenOhmReport->quantity_sold)->toBe(1)
        ->and($alphaSixteenOhmReport->attribute_name)->toBe('16 Ohm')
        ->and($dailyReports)->toHaveCount(2);
});

test('product analytics request rejects a reversed date range', function (): void {
    $request = ProductAnalyticsRequest::create('/admin/orders/product-analytics', 'GET', [
        'from_date' => '2099-06-30',
        'to_date' => '2099-06-01',
    ]);

    $request->setContainer(app());
    $request->setRedirector(app('redirect'));

    expect(function () use ($request): void {
        $request->validateResolved();
    })
        ->toThrow(ValidationException::class);
});
