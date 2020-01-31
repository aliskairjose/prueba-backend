<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MyOrder extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'suplier_id',
        'payment_method_id',
        'status',
        'dir',
        'phone',
        'total',
        'type',
        'quantity',
        'product_id',
        'variation_id'
    ];

    /**
     * Relacion uno a muhos con RecordController (OrderHistory)
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
