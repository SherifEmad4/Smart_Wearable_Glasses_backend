<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
    ];
    
    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locationHistories()
    {
        return $this->hasMany(LocationHistory::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
