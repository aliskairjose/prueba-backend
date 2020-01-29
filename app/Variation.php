<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Variation extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['suggested_price', 'sale_price', 'product_id', 'stock'];

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_variations');
    }

}
