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
    const IS_CAJERO = 'Cajero';
    const IS_USUARIO = 'Usuario';  
    const IS_ASESOR = 'Asesor'; 
    
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'tipo_doc',
        'num_documento',
        'apellido',
        'direccion',
        'rol',
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
        return $this->rol == User::IS_CAJERO;
    }
    
    public function accounts() {
        return $this->hasMany(Account::class);
    }
    
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    
    
}
