<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = ['store_id', 'picture_1', 'picture_2', 'picture_3'];
}
