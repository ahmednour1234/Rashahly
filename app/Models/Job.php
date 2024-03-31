<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'company_id',
        'job_type',
        'salary',
        // Add other fillable fields as needed
    ];

    // Define relationship with Company model
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function userJob()
    {
        return $this->hasMany(UserCV::class);
    }
}
