<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class City extends Model
{
    use Notifiable;

    protected $fillable = [ 'id','department_id','name', 'rate_type','trajectory_type'];

    /**
     * Relacion Mucho a Muchos con Productos
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
