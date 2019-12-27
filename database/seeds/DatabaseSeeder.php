<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Account;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREING_KEYS_CHECKS = 0');
        
        Transaction::truncate();
        Account::trucate();
        User::truncate();
        
        $cantidadUsuarios = 1;
        $cantidadCuentas = 1;
        $cantidadTransacciones = 1;
        
        factory(User::class, $cantidadUsuarios)->create();
        factory(Account::class, $cantidadCuentas)->create();
        factory(Transaction::class, $cantidadTransacciones)->create();
        
    }
}
