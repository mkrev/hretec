<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\{
    Economy,
    Party,
    Ideology,
    Role
};
use App\Models\Contents\{
    Article,
    Discussion,
    Video,
    Poll
};
use App\Models\Contents\Parts\Like;
use Storage;

class User extends Authenticatable implements JWTSubject/*, MustVerifyEmail*/
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ideology_id',
        'economy_id',
        'party_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo',
    ];

    protected $with = [
        'ideology',
        'economy',
        'party',
        'role',
        'likes',
    ];

    public function economy()
    {
        return $this->belongsTo(Economy::class);
    }

    public function ideology()
    {
        return $this->belongsTo(Ideology::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function quests()
    {
        return $this->belongsToMany(Quest::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }


    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoAttribute()
    {
        return Storage::url("users/{$this->name}/photo.jpg");
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
