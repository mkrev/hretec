<?php

namespace App\Models\Contents;

use App\Models\User;
use App\Models\Contents\Parts\Like;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
    ];

    protected $with = [
        'user',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
