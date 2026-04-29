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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 20)->nullable()->after('email'); // Or adjust placement
            $table->string('zip_postal_code', 10)->nullable();
            $table->string('locality_house_no')->nullable(); // Defaults to VARCHAR(255)
            $table->string('street_address')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city_district_town', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('user_type', 20)->default('user');
            $table->index('user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'zip_postal_code',
                'locality_house_no',
                'street_address',
                'landmark',
                'city_district_town',
                'state',
                'user_type'
            ]);
        });
    }
};
