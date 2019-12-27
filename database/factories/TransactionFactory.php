<?php

use Faker\Generator as Faker;
use App\Transaction;

use App\User;
use App\Account;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'tr_tipo' => $faker->randomElement([Transaction::TYPE_RETIRO, Transaction::TYPE_CONSIGNACION]),
        'tr_fecha_creacion' => $faker->dateTime(),
        'tr_monto' => $faker->numberBetween(0,4),
        'tr_descripcion' => $faker->paragraph(1),
        'user_id' => User::all()->random()->id,
        'account_id' => Account::all()->random()->id,
    ];
});
