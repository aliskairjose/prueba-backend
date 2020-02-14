<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WithdrawalRequest extends Model
{
    use Notifiable;

    protected $fillable = ['amount', 'user_id', 'status','created_at','updated_at'];

    /**
     * Relacion uno a uno con User (UserController)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
