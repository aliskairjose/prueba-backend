<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SeparateDetail extends Model
{
    use Notifiable;

    protected $fillable = ['separate_inventory_id', 'product_id', 'variation_id', 'quantity', 'price'];
}
