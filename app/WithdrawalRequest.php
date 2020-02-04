<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WithdrawalRequest extends Model
{
    use Notifiable;

    protected $fillable = [ 'amount', 'user_id', 'status' ];
}
