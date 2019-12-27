<?php

use Faker\Generator as Faker;
use App\Account;
use App\User;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'ac_balance' => $faker->numberBetween(0,10),
        'ac_number' => $faker->numberBetween(0,10),
        'ac_password' => $faker->numberBetween(0,4),
        'ac_state' => $faker->randomElement([Account::ACCOUNT_ACTIVE,Account::ACCOUNT_DISABLE]),
        'user_id' => User::all()->random()->id,
    ];
});
