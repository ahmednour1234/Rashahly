<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolveProblem extends Model
{
    protected $fillable = ['user_id', 'file', 'pdf', 'problem_id'];

    // Define relationships if necessary
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
}
