<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    // Relationships
    public function guardians()
    {
        return $this->hasMany(Guardian::class);
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
    return $this->hasMany(Message::class, 'guardian_id');
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
