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
        'variation_id',
        'notes',
        'price',
        'total_order',
        'name',
        'surname',
        'street_address',
        'country',
        'state',
        'city',
        'zip_cde'
    ];

    /**
     * Relacion uno a muhos con RecordController (OrderHistory)
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
