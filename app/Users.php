<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $hidden = [
        'key'
    ];
    protected $fillable = [
        'identifier','auth_hash','connection_key','auth_type','key'
    ];

}
