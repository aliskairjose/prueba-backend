<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Record extends Model
{
    use Notifiable;

    protected $fillable = [ 'user_id', 'id_reference', 'text_reference', 'new_value', 'previous_value' ];
}
