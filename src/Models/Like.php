<?php

namespace Mohiqssh\Groups\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id'];

    protected static function booted()
    {
        static::created(function ($modelInstance) {

        });
    }
}
