<?php

namespace App\Entities;

class Post extends BaseSoftDeletesModel
{
    protected $guarded = [];

    protected $visible = [
        'id', 'text', 'user_id', 'heading_id', 'created_at', 'author'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
}
