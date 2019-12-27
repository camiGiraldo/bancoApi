<?php

namespace App;

use App\Account;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const TYPE_RETIRO = 'Retiro';
    const TYPE_CONSIGNACION = 'Consignacion';
    
    protected $fillable =[
        'tr_tipo',
        'tr_fecha_creacion',
        'tr_monto',
        'tr_descripcion',
        'user_id',
        'account_id',        
    ];
    public function transacctionTypeRetiro($param) {
        return $this->tr_tipo == Account::ACCOUNT_ACTIVE;
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function account() {
        
        return $this->belongsTo(Account::class);
    }
}