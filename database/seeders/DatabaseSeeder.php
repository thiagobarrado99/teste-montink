<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'id' => 1,
            'name' => 'Administrator Montink',
            'email' => 'admin@montink.com',
        ]);

        Coupon::insert([
            [
                "name" => "Cupom R$ 15 OFF",
                "code" => "CUPO-15RS-OFFF",
                "is_percentage" => false,
                "discount_value" => 15,
                "minimum_price" => 50,
                "max_uses" => null,
                "expires_at" => date_create()->modify("+7 days")->format("Y-m-d H:i:s"),
                "user_id" => 1,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Cupom 10% OFF",
                "code" => "CUPO-10PC-OFFF",
                "is_percentage" => true,
                "discount_value" => 10,
                "minimum_price" => 25,
                "max_uses" => 50,
                "expires_at" => date_create()->modify("+7 days")->format("Y-m-d H:i:s"),
                "user_id" => 1,
                "created_at" => now(),
                "updated_at" => now()
            ]
        ]);
    }
}
