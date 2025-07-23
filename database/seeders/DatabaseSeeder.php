<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShippingRule;
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

        $product_simple = new Product([
            "name" => "Camiseta basica preta",
            "price" => 25,
            'user_id' => 1
        ]);
        if($product_simple->save())
        {
            $product_simple->inventory()->create([
                "quantity" => 5
            ]);
        }

        $product_variations = new Product([
            "name" => "Camiseta basica colorida",
            "price" => 30,
            'user_id' => 1
        ]);
        if($product_variations->save())
        {
            $productVariation_1 = $product_variations->products()->create([
                "name" => "Vermelha",
                "price" => 30,
                'user_id' => 1
            ]);
            $productVariation_2 = $product_variations->products()->create([
                "name" => "Verde",
                "price" => 30,
                'user_id' => 1
            ]);
            $productVariation_3 = $product_variations->products()->create([
                "name" => "Azul",
                "price" => 30,
                'user_id' => 1
            ]);

            $productVariation_1->inventory()->create([
                "quantity" => 4
            ]);

            $productVariation_2->inventory()->create([
                "quantity" => 8
            ]);

            $productVariation_3->inventory()->create([
                "quantity" => 12
            ]);
        }

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

        ShippingRule::insert([
            [
                "type" => 0,
                "range_start" => 51.99,
                "range_end" => null,
                "price" => 20,
                "user_id" => 1,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "type" => 2,
                "range_start" => 52,
                "range_end" => 166.59,
                "price" => 15,
                "user_id" => 1,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "type" => 2,
                "range_start" => 166.60,
                "range_end" => 200,
                "price" => 20,
                "user_id" => 1,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "type" => 1,
                "range_start" => 200.01,
                "range_end" => null,
                "price" => 0,
                "user_id" => 1,
                "created_at" => now(),
                "updated_at" => now()
            ],
        ]);
    }
}
