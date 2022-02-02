<?php

namespace Mohiqssh\Groups\Traits;

use Mohiqssh\Groups\Models\Group;

trait HasGroups
{
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }
}
