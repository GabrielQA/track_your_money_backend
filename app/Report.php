<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'small_name','initial_amount'
    ];
}
