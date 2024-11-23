<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'guardian_id',
        'location_id',
        'text',
        // 'sent_at',
        // 'is_sent',
    ];
    public $timestamps = false;

     // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'user');
    }

    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id')->where('role', 'guardian');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
