<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['category_id', 'article_id', 'title', 'description', 'url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
