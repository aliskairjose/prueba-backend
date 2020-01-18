<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductPhoto extends Model
{
    use Notifiable;

    protected $fillable = ['url', 'main', 'product_id', 'variation_id'];

}
