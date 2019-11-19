<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'zipcode' => $faker->postcode,
        'profile' => $faker->image(),
        'country_id' => 1,
        'start_day' => $faker->dayOfWeek(),
        'end_day' => $faker->dayOfWeek(),
        'show_on' => $faker->dayOfWeek(),
    ];
});
