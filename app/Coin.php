<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Coin extends Model
{
    protected $fillable = [
        'user_id', 'small_name', 'symbol', 'description', 'rate','available'
    ];

}
