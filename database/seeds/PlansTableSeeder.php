<?php

use App\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'low_monthly',
            'braintree_plan_id' => 'low_monthly',
            'price' => '500',
            'priceName' => 'Five',
            'period' => 'month',
        ]);

        Plan::create([
            'name' => 'high_monthly',
            'braintree_plan_id' => 'high_monthly',
            'price' => '1000',
            'priceName' => 'Ten',
            'period' => 'month',
        ]);
    }
}
