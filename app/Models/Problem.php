<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
{
    return $this->belongsTo(Company::class);
}
public function solveProblem()
{
    return $this->hasMany(SolveProblem::class);
}
}
