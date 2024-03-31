<?php

// app/Models/UserImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_name',
    ];

    /**
     * Get the user that owns the image.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
