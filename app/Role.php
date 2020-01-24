<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use Notifiable;

    protected $fillable = [ 'id','name', 'guard_name'];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
