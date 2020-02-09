<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Trajectory extends Model
{
    use Notifiable;

    protected $fillable = [ 'id','from','until','price','rate_type'];
}
