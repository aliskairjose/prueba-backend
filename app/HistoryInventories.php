<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HistoryInventories extends Model
{
    use Notifiable;

    protected $fillable = [
        'product_id',
        'variation_id',
        'quantity',
        'payment_method_id',
        'total',
        'status'
    ];
}


