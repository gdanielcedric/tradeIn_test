<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'emoji', 'link', 'content', 'author_slug', 'author_avatar', 'featured_media'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }
}

