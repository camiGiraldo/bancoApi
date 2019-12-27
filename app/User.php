<?php

namespace App;

use App\Transaction;
use App\Account;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;//Importamos el trait

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const IS_CAJERO = 'true';
    const IS_USUARIO = 'false';  
    
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'tipo_doc',
        'num_documento',
        'apellido',
        'direccion',
        'is_cajero',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function isCajero() {
        return $this->is_cajero == User::IS_CAJERO;
    }
    
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    
    public function accounts() {
        return $this->hasMany(Account::class);
    }
}
