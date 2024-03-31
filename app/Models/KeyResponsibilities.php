<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyResponsibilities extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'name', 'job_id'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
