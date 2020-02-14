<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HistoryWithdrawal extends Model
{
    use Notifiable;

    protected $fillable = [ 'user_id', 'amount', 'status', 'withdrawal_request_id' ];

    public static function scopeFiltro($query, $id)
    {
        if($id){
            return $query->where('user_id', '=', $id)->get();
        }
    }
    public static function scopebyRequestId($query, $id)
    {
        if($id){
            return $query->where('withdrawal_request_id', '=', $id)->get();
        }
    }
}
