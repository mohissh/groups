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

    protected static function booted()
    {
        static::created(function ($modelInstance) {
            GroupStat::where('group_id', $modelInstance->group_id)->update([
                'member_count' => DB::raw('member_count + 1')
            ]);
        });
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
