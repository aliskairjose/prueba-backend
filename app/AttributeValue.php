<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AttributeValue extends Model
{
    use Notifiable;

    protected $fillable = [ 'value', 'attribute_id' ];

    /**
     * Método que muestra la relacion mucho a muchos con Variation
     */
    public function variations()
    {
        return $this->belongsToMany(Variation::class);
    }


}
