<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Arrival;
use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Arrival::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-30 days');
    return [
        'drivers_name' => $faker->name,
        'birth_date' => $faker->date(),
        'gender' => $faker->randomElement(['M', 'F']),
        'is_vehicle_owner' => $faker->boolean,
        'is_truck_loaded' => $faker->boolean,
        'drivers_license_category' => $faker->randomElement(['D', 'E', 'AD', 'AE']),
        'truck_id' => $faker->randomElement([1, 2, 3, 4, 5]),
        'origin_lat' => $faker->latitude,
        'origin_lng' => $faker->longitude,
        'destination_lat' => $faker->latitude,
        'destination_lng' => $faker->longitude,
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
