<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyWorkWithUs extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'data'];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
