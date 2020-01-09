<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RequestTestDetail extends Model
{
    use Notifiable;

    protected $fillable = ['request_test_id', 'product_id', 'variation_id', 'quantity', 'price'];
}
