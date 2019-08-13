<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transacction extends Model
{
    protected $fillable = [
        'user_id', 'type', 'acount','id_account', 'category', 'detail', 'amount'
    ];
}
