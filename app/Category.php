<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id','father_cat','category','type','description','available'
    ];
}
