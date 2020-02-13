<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class Product extends Model
{
    use Notifiable;

    /**
     *  The attributes thar are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'stock',
        'sale_price',
        'suggested_price',
        'user_id',
        'privated_product',
        'active',
        'sku',
        'weight',
        'length',
        'width',
        'height'
    ];

    /**
     * Método que define la relacion de uno a muchos con atributos
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * Método que deine la relacion de uno a muchos con variations
     */
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * Método que deine la relacion de uno a muchos con product photos
     */
    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    /**
     * Relacion mucho a muchos con Category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Relacion uno a uno con Usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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

    public static function scopeCategory($query, $category)
    {
        if ($category && $category > 0) {
            return $query->join('category_product', 'category_product.product_id', '=', 'products.id')
                ->join('categories', 'categories.id', '=', 'category_product.category_id')
                ->where('category_id', '=', $category);
            //  ->get();
        }
    }

    public static function scopeRango($query, $minPrice, $maxPrice)
    {

        if ($minPrice && $maxPrice === 0) {
            return $query->where('sale_price', '>=', $minPrice);
        }

        if ($maxPrice) {
            if ($maxPrice >= $minPrice) {
                return $query->where('sale_price', '>=', $minPrice)->where('sale_price', '<=', $maxPrice);
            }
        }
    }

    public static function scopeOrdenar($query, $sortBy)
    {
        switch ($sortBy) {
            case 'Precio mas bajo':
                return $query->orderBy('sale_price', 'asc')->get();
            case 'Precio mas alto':
                return $query->orderBy('sale_price', 'desc')->get();
            case 'SIMPLE':
                return $query->orderBy('type', 'asc')->get();
            case 'VARIABLE':
                return $query->orderBy('type', 'asc')->get();
            default:
                return $query->orderBy('sale_price', 'asc')->get();
        }
    }

    public static function scopeKeyword($query, $keyword)
    {
        if ($keyword) {
            // return $query->where('name', 'LIKE', '%'.$keyword.'%')->orWhere('description', 'LIKE', '%'.$keyword.'%');
            return $query->where('description', 'like', '%'.$keyword.'%');
        }
    }
}
