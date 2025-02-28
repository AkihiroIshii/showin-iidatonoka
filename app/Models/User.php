<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'password',
        'name',
        'school_id',
        'grade',
        'plan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'user_id',
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            //'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function records() {
        return $this->hasMany(Record::class);
    }

    public function targets() {
        return $this->hasMany(Target::class);
    }

    public function usualtargets() {
        return $this->hasMany(Usualtarget::class);
    }

    public function examresults() {
        return $this->hasMany(Examresult::class);
    }

    public function workrecords() {
        return $this->hasMany(Wordrecord::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'families', 'child_id', 'parent_id');
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'families', 'parent_id', 'child_id');
    }
}
