<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['id','name', 'phone', 'email', 'address'];

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }
}
