<?php

use Faker\Generator as Faker;
use \App\User;
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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'tipo_doc' => $faker->randomElement(['CC','TI','CE']),
        'num_documento'=>$faker->numberBetween(0,10),
        'apellido'=>$faker->word,
        'direccion'=>$faker->word,
        'rol'=>$faker->randomElement([User::IS_CAJERO, User::IS_USUARIO]),
        'remember_token' => str_random(10),
    ];
});
