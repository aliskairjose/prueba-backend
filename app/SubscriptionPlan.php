<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SubscriptionPlan extends Model
{
    use Notifiable;

    protected $fillable = [ 'name', 'description', 'active', 'auto_manage_delivery'];
}
