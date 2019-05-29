<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connections extends Model
{
    protected $fillable = [
        'user_id', 'connection_id','destination_id','subject'
    ];
}
