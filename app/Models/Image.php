<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

      // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'caption',
        'image',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
