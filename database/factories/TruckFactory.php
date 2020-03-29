<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Truck;
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

$factory->define(Truck::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement([
            'Caminhão 3/4',
            'Caminhão Toco',
            'Camihão Truck',
            'Carreta Simples',
            'Carreta Eixo Extendido'
        ]),
        'code' => $faker->randomElement([1, 2, 3, 4, 5]),
    ];
});
