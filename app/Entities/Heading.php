<?php

namespace App\Entities;

use App\Entities\BaseSoftDeletesModel;
use App\User;

class Heading extends BaseSoftDeletesModel
{
    protected $guarded = [];

    protected $visible = [
        'id', 'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscriptions()
    {
        return $this->belongsToMany(User::class, 'subscriptions')
            ->withTimestamps();
    }
}
