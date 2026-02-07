<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update halls: add more pricing columns
        Schema::table('halls', function (Blueprint $table) {
            $table->decimal('price_per_day', 10, 2)->nullable()->after('price_per_hour');
            $table->decimal('price_per_week', 10, 2)->nullable()->after('price_per_day');
            $table->decimal('price_per_month', 10, 2)->nullable()->after('price_per_week');
        });

        // Update bookings: billing_type, open end, custom price, closed_at
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('billing_type', ['hourly', 'daily', 'weekly', 'monthly'])->default('hourly')->after('hall_id');
            $table->decimal('unit_price', 10, 2)->default(0)->after('end_time');
            $table->boolean('is_open')->default(false)->after('total_price');
            $table->timestamp('closed_at')->nullable()->after('is_open');
        });

        // Make end_time nullable
        DB::statement('ALTER TABLE bookings MODIFY end_time TIME NULL');

        // Update bookings status enum to include 'open' and 'closed'
        DB::statement("ALTER TABLE bookings MODIFY status ENUM('confirmed','pending','cancelled','open','closed') DEFAULT 'pending'");

        // Seed default pricing settings
        $prices = [
            ['key' => 'default_price_per_hour', 'value' => '50', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'default_price_per_day', 'value' => '300', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'default_price_per_week', 'value' => '1500', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'default_price_per_month', 'value' => '4000', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($prices as $p) {
            DB::table('settings')->updateOrInsert(['key' => $p['key']], $p);
        }
    }

    public function down(): void
    {
        Schema::table('halls', function (Blueprint $table) {
            $table->dropColumn(['price_per_day', 'price_per_week', 'price_per_month']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['billing_type', 'unit_price', 'is_open', 'closed_at']);
        });

        DB::statement('ALTER TABLE bookings MODIFY end_time TIME NOT NULL');
        DB::statement("ALTER TABLE bookings MODIFY status ENUM('confirmed','pending','cancelled') DEFAULT 'pending'");

        DB::table('settings')->whereIn('key', [
            'default_price_per_hour', 'default_price_per_day',
            'default_price_per_week', 'default_price_per_month',
        ])->delete();
    }
};
