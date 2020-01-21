<?php

use App\models\Hr\Expense;
use Illuminate\Database\Seeder;

class ExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 4) as $index) {
            Expense::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'qty' => $faker->numberBetween($min = 1, $max = 10),
                'bought_by' => $faker->numberBetween($min = 1, $max = 10),
                'amount' => $faker->numberBetween($min = 300, $max = 5000),
                'purchased_from' => $faker->word,
                'item' => $faker->word,
                'purchase_date' => $faker->date,
                'remarks' => $faker->text,
            ]);
        }
    }
}
