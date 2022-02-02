<?php

namespace Mohiqssh\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use Mohiqssh\Groups\Traits\Likes;
use Mohiqssh\Groups\Traits\Reporting;

class Post extends Model
{
    use Likes;
    use Reporting;

    protected $fillable = ['title', 'user_id', 'body', 'type', 'extra_info'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->with('commentator');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Creates a post.
     *
     * @param array $data
     *
     * @return Post
     */
    public function make($data)
    {
        return $this->create($data);
    }

    /**
     * Updates Post.
     *
     * @param int   $postId
     * @param array $data
     *
     * @return Post
     */
    public function updatePost($postId, $data)
    {
        $this->where('id', $postId)->update($data);

        return $this;
    }
}
