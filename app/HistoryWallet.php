<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HistoryWallet extends Model
{
    use Notifiable;

    protected $fillable = [ 'wallet_id', 'amount', 'status', 'type','payu_orderid' ];

}
