<?php

namespace App\Models\Contents;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contents\Parts\Like;
use Storage;

class Video extends Model
{
    public const FILE_DIR = 'contents/videos';

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    protected $appends = [
        'movie_url',
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

    public function getMovieUrlAttribute()
    {
        return Storage::url("contents/videos/{$this->id}/{$this->file}");
    }
}
