<?php

use App\models\Hr\Attendace;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
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
            Attendace::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'in_time' => $faker->time,
                'out_time' => $faker->time,
                'hours_worked' => $faker->numberBetween($min = 1, $max = 10),
                'status' => $faker->word,
                'over_time' =>  $faker->numberBetween($min = 1, $max = 10),
            ]);
        }
    }
}
