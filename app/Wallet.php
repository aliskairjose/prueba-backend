<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Wallet extends Model
{
    use Notifiable;

    protected $fillable = [ 'id','user_id', 'currency_id', 'amount' ];


}
