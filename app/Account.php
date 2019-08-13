<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'user_id','coin','small_name','description','initial_amount','available'
    ];
}
