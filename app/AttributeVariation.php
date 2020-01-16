<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AttributeVariation extends Model
{
    use Notifiable;

    protected $fillable = ['variation_id', 'attribute_value_id'];
}
