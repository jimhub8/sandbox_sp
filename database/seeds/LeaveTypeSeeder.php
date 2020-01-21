<?php

use App\models\Hr\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
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
            LeaveType::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'leave_type' => $faker->word,
                'description' => $faker->text,
            ]);
        }
    }
}
