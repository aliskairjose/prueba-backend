<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PayuTransaction extends Model
{
    use Notifiable;

    /**
     *  The attributes thar are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'paymentmethod',
        'orderid',
        'transactionid',
        'state',
        'responsecode',
        'amount',
        'currency_id',

    ];


    /**
     * Relacion uno a uno con Usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
