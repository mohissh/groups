<?php

namespace Mohiqssh\Groups\Traits;

use Mohiqssh\Groups\Models\Post;

trait HasPosts
{
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}
