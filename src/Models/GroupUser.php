<?php

namespace Mohiqssh\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupUser extends Model
{
    const role = [
        'admin' => 'admin',
        'user' => 'user'
    ];
    protected $table = 'group_user';

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
