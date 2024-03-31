<?php

// app/Models/ProfileType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'bio',
        'full_name',
        'profession',
        // Add other fillable fields as needed
    ];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
