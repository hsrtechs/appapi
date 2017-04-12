<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Carbon\Carbon;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'password' => 'jainjain',
        'number' => $faker->numberBetween(),
        'email' => $faker->email,
        'country' => $faker->country,
        'credits' => $faker->numberBetween(0,500),
        'device_id' => str_random(),
        'access_token' => str_random(32),
        'verified' => $faker->boolean(),
    ];
});

$factory->define(App\Offer::class, function (Faker\Generator $faker) {
    $name = $faker->lastName;
    return [
        'url' => $faker->url,
        'name' => $name,
        'image_location' => $faker->imageUrl(),
        'package_id' => strrev(strtolower($name.'.'.$faker->domainName)),
        'credits' => $faker->numberBetween(0,25),
        'country' => $faker->country,
        'desc' => $faker->text,
        'hidden' => $faker->boolean(),
        'valid_until' => Carbon::now()->addYears(random_int(-10,10))->addMonths(random_int(-50,50))->addDays(random_int(-200,200)),
    ];
});