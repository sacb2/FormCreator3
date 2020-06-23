<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveUserTypes extends Model
{

    protected $table = 'user_types';

    protected $fillable = [
        'id', 'name'
    ];
}
