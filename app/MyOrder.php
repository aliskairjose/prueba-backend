<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        'zip_cde',
        'shipping'
    ];

    /**
     * Relacion uno a muchos con HistoryOrders (HistoryOrders)
     */
    public function history()
    {
        return $this->hasMany(HistoryOrder::class, 'order_id');
    }

    public static function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired']);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid']);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent']);
        }
        return $user;
    }


}
