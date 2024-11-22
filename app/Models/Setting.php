<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    // Disable automatic timestamps
    public $timestamps = false;

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'personal_assistant_enable',
        'vibration_enable',
        'obstacle_avoidance_enable',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
