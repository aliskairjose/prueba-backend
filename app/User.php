<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 'surname', 'email', 'birthday', 'status', 'password', 'register_approved', 'banned', 'approve_product',
      'role_id', 'subscription_plan_id', 'phone', 'notes', 'url','store_name','store_url','consumer_key','consumer_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*  protected $casts = [
         'email_verified_at' => 'datetime',
     ]; */

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Método publico que define la relacion uno a muchos con productos
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relacion uno a uno con wallet
     * @return HasOne
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Relacion uno a uno con Planes
     * @return BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
