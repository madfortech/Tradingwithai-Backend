<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::updateOrCreate(
            ['slug' => 'basic'],
            [
                'name' => 'Basic',
                'price' => 0,
                'stripe_price_id' => null,
                'ai_credits' => 200,
                'daily_ai_credit_limit' => 200,
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Pro',
                'price' => 599,
                'stripe_price_id' => 'price_1U5f4ISA2LnORYoTdEIPZout',
                'ai_credits' => 5000,
                'daily_ai_credit_limit' => 300,
                'is_active' => true,
            ]
        );

    }
}
