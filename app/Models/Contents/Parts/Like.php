<?php

namespace App\Models\Contents\Parts;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'comment_id',
        'user_id',
        'is_like',
    ];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
