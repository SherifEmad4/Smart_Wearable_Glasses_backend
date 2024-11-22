<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'address',
        'content',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
