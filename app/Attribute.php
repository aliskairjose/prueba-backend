<?php

namespace App;

use App\Http\Resources\AttributeValue;
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
    protected $fillable = ['description', 'product_id'];

    /**
     * Método que define la relacion de uno a muchos con attributes values
     */
    public function attributesValues()
    {
        return $this->hasMany(AttributesValues::class);
    }

     /**
     * Método que muestra la relacion muchos a muchos con Variations
     */
    public function variatons()
    {
        return $this->belongsTo(Variation::class);
    }

}
