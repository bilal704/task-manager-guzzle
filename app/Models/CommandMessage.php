<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandMessage extends Model
{
    protected $fillable = ['user_id', 'message', 'displayed'];
}
