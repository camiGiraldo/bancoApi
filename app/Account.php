<?php

namespace App;

use App\User;
use App\Transaction;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    const ACCOUNT_ACTIVE = 'Activa';
    const ACCOUNT_DISABLE = 'Inactiva';
    
    protected $fillable =[
        'ac_balance',
        'ac_number',
        'ac_password',
        'ac_state',
        'user_id',     
    ];
    
    public function accountIsActive($param) {
        return $this->ac_state == Account::ACCOUNT_ACTIVE;
    }
    
    public function user($param) {
        return $this->belongsTo(User::class);
    }
    
    public function transactions() {
        return $this->hasMany(Transaction::class);
        
    }
}
