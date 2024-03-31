<?php

// app/Models/UserExperience.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'experience_id',
        // Add other fillable fields as needed
    ];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship with Experience model
    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}
