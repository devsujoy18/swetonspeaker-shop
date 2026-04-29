<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('mrp', 10, 2)->default(0.00)->after('status');
            $table->decimal('price', 10, 2)->default(0.00)->after('mrp');
            $table->tinyInteger('shop_status')->default(0)->after('price');
            $table->integer('shop_order_no')->default(0)->after('shop_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('shop_order_no');
            $table->dropColumn('shop_status');
            $table->dropColumn('price');
            $table->dropColumn('mrp');
        });
    }
};
