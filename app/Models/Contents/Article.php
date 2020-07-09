<?php

namespace App\Models\Contents;

use App\Models\User;
use App\Models\Contents\Parts\Like;
use Storage;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public const FILE_DIR = 'contents/articles';

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    protected $appends = [
        'picture_url',
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

    public function getPictureUrlAttribute()
    {
        return Storage::url("contents/articles/{$this->id}/{$this->file}");
    }
}
