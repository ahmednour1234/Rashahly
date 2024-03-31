<?php

// app/Models/Company.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'user_id',
        'site',
        'country',
        'founded_at',
        'number_of_employees',
        'description',
        // Add other fillable fields as needed
    ];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function job()
    {
        return $this->hasMany(Job::class);
    }
    public function whyWorkWithUs()
    {
        return $this->hasMany(WhyWorkWithUs::class);
    }
    public function reviewCompany()
    {
        return $this->hasMany(ReviewCompany::class);
    }
}
