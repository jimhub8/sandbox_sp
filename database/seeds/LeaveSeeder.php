<?php

use App\models\Hr\Leave;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
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
            Leave::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'leave_type' => $faker->numberBetween($min = 1, $max = 10),
                'date_from' => $faker->date,
                'date_to' => $faker->date,
                'reason' => $faker->text,
                'status' => $faker->numberBetween($min = 1, $max = 3),
                'days' => $faker->numberBetween($min = 1, $max = 10),
                'remark' => $faker->text,
            ]);
        }
    }
}
