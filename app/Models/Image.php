<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image); // Assumes 'image' holds the path like 'images/filename.jpg'
    }

}
