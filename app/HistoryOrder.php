<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HistoryOrder extends Model
{
    use Notifiable;

    protected $fillable = [ 'user_id', 'order_id', 'status', 'shipping'];

}
