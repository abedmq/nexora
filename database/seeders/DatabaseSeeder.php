<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Domains\Customer\Models\Customer;
use App\Domains\Hall\Models\Hall;
use App\Domains\Booking\Models\Booking;
use App\Domains\Subscription\Models\Subscription;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Admin User =====
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@nexora.com',
            'phone' => '0501234567',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // ===== Customers (العملاء) =====
        $customers = [
            ['name' => 'أحمد محمد', 'email' => 'ahmed@email.com', 'phone' => '0501234567', 'type' => 'vip'],
            ['name' => 'سارة علي', 'email' => 'sara@email.com', 'phone' => '0559876543', 'type' => 'regular'],
            ['name' => 'خالد عمر', 'email' => 'khaled@email.com', 'phone' => '0541112233', 'type' => 'vip'],
            ['name' => 'نورة سعد', 'email' => 'noura@email.com', 'phone' => '0534445566', 'type' => 'regular'],
            ['name' => 'فهد ناصر', 'email' => 'fahad@email.com', 'phone' => '0567778899', 'type' => 'regular'],
            ['name' => 'ليلى حسن', 'email' => 'layla@email.com', 'phone' => '0523334455', 'type' => 'vip'],
            ['name' => 'عمر يوسف', 'email' => 'omar@email.com', 'phone' => '0545556677', 'type' => 'regular'],
            ['name' => 'هند محمود', 'email' => 'hind@email.com', 'phone' => '0556667788', 'type' => 'regular'],
            ['name' => 'ماجد سلطان', 'email' => 'majed@email.com', 'phone' => '0578889900', 'type' => 'vip'],
            ['name' => 'ريم عبدالله', 'email' => 'reem@email.com', 'phone' => '0509991122', 'type' => 'regular'],
        ];

        foreach ($customers as $c) {
            Customer::create($c);
        }

        // ===== Halls (القاعات / المكاتب) =====
        $halls = [
            ['name' => 'قاعة المؤتمرات الكبرى', 'type' => 'meeting_room', 'capacity' => 50, 'price_per_hour' => 200, 'amenities' => 'جهاز عرض، سبورة ذكية، مكيف، نظام صوت', 'status' => 'available'],
            ['name' => 'قاعة الاجتماعات A', 'type' => 'meeting_room', 'capacity' => 20, 'price_per_hour' => 150, 'amenities' => 'شاشة عرض، واي فاي، مكيف', 'status' => 'booked'],
            ['name' => 'قاعة الاجتماعات B', 'type' => 'meeting_room', 'capacity' => 15, 'price_per_hour' => 120, 'amenities' => 'شاشة عرض، واي فاي', 'status' => 'available'],
            ['name' => 'مكتب خاص 101', 'type' => 'private_office', 'capacity' => 4, 'price_per_hour' => 100, 'amenities' => 'مكيف، إنترنت عالي السرعة، طابعة', 'status' => 'available'],
            ['name' => 'مكتب خاص 102', 'type' => 'private_office', 'capacity' => 6, 'price_per_hour' => 120, 'amenities' => 'شاشة عرض، طابعة، إنترنت', 'status' => 'booked'],
            ['name' => 'مساحة العمل المشتركة', 'type' => 'coworking', 'capacity' => 30, 'price_per_hour' => 50, 'amenities' => 'مكاتب مشتركة، واي فاي، مطبخ، طابعة', 'status' => 'available'],
            ['name' => 'قاعة التدريب الرئيسية', 'type' => 'training_room', 'capacity' => 40, 'price_per_hour' => 180, 'amenities' => 'بروجكتور، سبورة ذكية، مايكروفون، كاميرا', 'status' => 'available'],
            ['name' => 'قاعة التدريب الصغيرة', 'type' => 'training_room', 'capacity' => 20, 'price_per_hour' => 130, 'amenities' => 'بروجكتور، سبورة، مايكروفون', 'status' => 'available'],
            ['name' => 'مكتب خاص 103', 'type' => 'private_office', 'capacity' => 2, 'price_per_hour' => 80, 'amenities' => 'مكيف، إنترنت، هاتف', 'status' => 'available'],
            ['name' => 'قاعة VIP', 'type' => 'meeting_room', 'capacity' => 10, 'price_per_hour' => 250, 'amenities' => 'تجهيزات فاخرة، شاشة 75 بوصة، ضيافة', 'status' => 'available'],
        ];

        foreach ($halls as $h) {
            Hall::create($h);
        }

        // ===== Bookings (الحجوزات) =====
        $bookings = [
            ['customer_id' => 1, 'hall_id' => 1, 'booking_date' => '2026-02-07', 'start_time' => '10:00', 'end_time' => '13:00', 'total_price' => 600, 'status' => 'confirmed'],
            ['customer_id' => 2, 'hall_id' => 4, 'booking_date' => '2026-02-07', 'start_time' => '09:00', 'end_time' => '17:00', 'total_price' => 800, 'status' => 'pending'],
            ['customer_id' => 3, 'hall_id' => 6, 'booking_date' => '2026-02-06', 'start_time' => '08:00', 'end_time' => '13:00', 'total_price' => 250, 'status' => 'confirmed'],
            ['customer_id' => 4, 'hall_id' => 7, 'booking_date' => '2026-02-06', 'start_time' => '14:00', 'end_time' => '20:00', 'total_price' => 1080, 'status' => 'cancelled'],
            ['customer_id' => 5, 'hall_id' => 1, 'booking_date' => '2026-02-05', 'start_time' => '10:00', 'end_time' => '12:00', 'total_price' => 400, 'status' => 'confirmed'],
            ['customer_id' => 6, 'hall_id' => 5, 'booking_date' => '2026-02-05', 'start_time' => '09:00', 'end_time' => '17:00', 'total_price' => 960, 'status' => 'confirmed'],
            ['customer_id' => 7, 'hall_id' => 3, 'booking_date' => '2026-02-04', 'start_time' => '13:00', 'end_time' => '16:00', 'total_price' => 360, 'status' => 'pending'],
            ['customer_id' => 8, 'hall_id' => 8, 'booking_date' => '2026-02-04', 'start_time' => '09:00', 'end_time' => '12:00', 'total_price' => 390, 'status' => 'confirmed'],
            ['customer_id' => 9, 'hall_id' => 10, 'booking_date' => '2026-02-03', 'start_time' => '10:00', 'end_time' => '14:00', 'total_price' => 1000, 'status' => 'confirmed'],
            ['customer_id' => 10, 'hall_id' => 2, 'booking_date' => '2026-02-03', 'start_time' => '08:00', 'end_time' => '11:00', 'total_price' => 450, 'status' => 'cancelled'],
            ['customer_id' => 1, 'hall_id' => 7, 'booking_date' => '2026-02-02', 'start_time' => '14:00', 'end_time' => '18:00', 'total_price' => 720, 'status' => 'confirmed'],
            ['customer_id' => 3, 'hall_id' => 1, 'booking_date' => '2026-02-01', 'start_time' => '09:00', 'end_time' => '12:00', 'total_price' => 600, 'status' => 'confirmed'],
            ['customer_id' => 2, 'hall_id' => 6, 'booking_date' => '2026-02-08', 'start_time' => '10:00', 'end_time' => '15:00', 'total_price' => 250, 'status' => 'pending'],
            ['customer_id' => 5, 'hall_id' => 9, 'booking_date' => '2026-02-08', 'start_time' => '09:00', 'end_time' => '13:00', 'total_price' => 320, 'status' => 'pending'],
            ['customer_id' => 6, 'hall_id' => 3, 'booking_date' => '2026-02-09', 'start_time' => '14:00', 'end_time' => '17:00', 'total_price' => 360, 'status' => 'pending'],
        ];

        foreach ($bookings as $b) {
            Booking::create($b);
        }

        // ===== Subscriptions (الاشتراكات) =====
        $subscriptions = [
            ['customer_id' => 1, 'type' => 'monthly', 'start_date' => '2026-01-01', 'end_date' => '2026-02-01', 'price' => 500, 'status' => 'active'],
            ['customer_id' => 2, 'type' => 'daily', 'start_date' => '2026-02-07', 'end_date' => '2026-02-07', 'price' => 75, 'status' => 'active'],
            ['customer_id' => 3, 'type' => 'special', 'start_date' => '2025-12-01', 'end_date' => '2026-02-10', 'price' => 1200, 'status' => 'expiring_soon'],
            ['customer_id' => 4, 'type' => 'monthly', 'start_date' => '2025-11-01', 'end_date' => '2025-12-01', 'price' => 500, 'status' => 'expired'],
            ['customer_id' => 5, 'type' => 'daily', 'start_date' => '2026-02-07', 'end_date' => '2026-02-07', 'price' => 75, 'status' => 'active'],
            ['customer_id' => 6, 'type' => 'special', 'start_date' => '2026-01-15', 'end_date' => '2026-04-15', 'price' => 3000, 'status' => 'active'],
            ['customer_id' => 7, 'type' => 'monthly', 'start_date' => '2026-02-01', 'end_date' => '2026-03-01', 'price' => 500, 'status' => 'active'],
            ['customer_id' => 8, 'type' => 'daily', 'start_date' => '2026-02-06', 'end_date' => '2026-02-06', 'price' => 75, 'status' => 'expired'],
            ['customer_id' => 9, 'type' => 'special', 'start_date' => '2026-01-01', 'end_date' => '2026-06-01', 'price' => 5000, 'status' => 'active'],
            ['customer_id' => 10, 'type' => 'monthly', 'start_date' => '2026-01-15', 'end_date' => '2026-02-15', 'price' => 500, 'status' => 'expiring_soon'],
        ];

        foreach ($subscriptions as $s) {
            Subscription::create($s);
        }

        // ===== Settings (الإعدادات) =====
        $settings = [
            ['key' => 'company_name', 'value' => 'نكسورا'],
            ['key' => 'company_email', 'value' => 'info@nexora.com'],
            ['key' => 'company_phone', 'value' => '0501234567'],
            ['key' => 'company_address', 'value' => 'الرياض، المملكة العربية السعودية'],
            ['key' => 'currency', 'value' => 'SAR'],
            ['key' => 'timezone', 'value' => 'Asia/Riyadh'],
        ];

        foreach ($settings as $s) {
            \DB::table('settings')->insert(array_merge($s, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ===== Pages & Menus =====
        $this->call(PageSeeder::class);
        $this->call(MenuSeeder::class);

        // ===== Website (Homepage Sections, Testimonials, Partners) =====
        $this->call(WebsiteSeeder::class);
    }
}
