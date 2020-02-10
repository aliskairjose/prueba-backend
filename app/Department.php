<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Department extends Model
{
    use Notifiable;

    protected $fillable = [ 'id','name','country_id'];

    /**
     * Relacion Mucho a Muchos con Productos
     */
    public function cities()
    {
        return $this->belongsToMany(City::class);
    }
}
