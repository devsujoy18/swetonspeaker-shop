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
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('shop_status')->default(0)->after('show_on_home');
            $table->integer('shop_order_no')->default(0)->after('shop_status');
            $table->tinyInteger('shop_show_on_home')->default(0)->after('shop_order_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['shop_status', 'shop_order_no', 'shop_show_on_home']);
        });
    }
};
