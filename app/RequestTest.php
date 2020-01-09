<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RequestTest extends Model
{
    use Notifiable;

    protected $fillable = [ 'user_id', 'suplier_id', 'payment_method_id', 'status', 'total'];

}
