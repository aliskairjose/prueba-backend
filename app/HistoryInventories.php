<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HistoryInventories extends Model
{
    use Notifiable;

    protected $fillable = [
        'product_id',
        'variation_id',
        'quantity',
        'payment_method_id',
        'total',
        'status'
    ];


    public static function scopeFilter($query, $request)
    {
        if($request->type === 'PRODUCTOS'){
            return $query->where('product_id','=', $request->id)->get();
        }

        if($request->type === 'DROPSHIPPER'){
            return $query->where('product_id','=', $request->id)->get();
        }
    }

}


