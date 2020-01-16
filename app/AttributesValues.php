<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AttributesValues extends Model
{
    use Notifiable;

    protected $fillable = [ 'value', 'attribute_id' ];
}
