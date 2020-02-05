<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Currency extends Model
{
    use Notifiable;

    protected $fillable = [ 'id','name', 'code','country_id'];
}
