<?php

namespace App\Models\Contents;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Contents\Parts\Like;

class Discussion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
