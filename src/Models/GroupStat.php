<?php

namespace Mohiqssh\Groups\Models;

use Illuminate\Database\Eloquent\Model;

class GroupStat extends Model
{
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
