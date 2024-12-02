<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relationships

    // Guardians assigned to this user
    public function guardians()
    {
        return $this->hasMany(UserGuardian::class, 'user_id');
    }

    // Users assigned to this guardian
    public function users()
    {
        return $this->hasMany(UserGuardian::class, 'guardian_id');
    }

    // Define the "user" relationship for a guardian
    public function ward()
    {
        return $this->hasOne(User::class, 'guardian_id');
    }
    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function locationHistories()
    {
        return $this->hasMany(LocationHistory::class);
    }

    public function messages()
    {
    return $this->hasMany(Message::class, 'user_id');
    }

    public function guardianmessages()
    {
        return $this->hasMany(Message::class, 'user_id')->whereHas('user', function ($query) {
            $query->where('role', 'guardian');
        });
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
