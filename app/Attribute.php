<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Attribute extends Model
{
    use Notifiable;

    /**
     *  The attributes thar are mass assignable
     *
     * @var array
     */
    protected $fillable = ['description', 'product_id', 'isVariation'];

    /**
     * Método que define la relacion de uno a muchos con attributes values
     */
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }


}
