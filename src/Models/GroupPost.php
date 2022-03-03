<?php

namespace Mohiqssh\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupPost extends Model
{
    protected $table = 'group_post';

    protected static function booted()
    {
        static::created(function ($modelInstance) {
            GroupStat::where('group_id', $modelInstance->group_id)->update([
                'post_count' => DB::raw('post_count + 1')
            ]);
        });
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
