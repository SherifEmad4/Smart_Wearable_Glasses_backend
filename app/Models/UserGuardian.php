<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGuardian extends Model
{
    use HasFactory;
    protected $table = 'users_guardians';

      // Define the fillable attributes
      protected $fillable = [
        'user_id',
        'guardian_id',
    ];

    // Relationships

    // The user who is being guarded
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // The guardian assigned to the user
    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }
}
