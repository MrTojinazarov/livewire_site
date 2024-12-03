<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ([
        'category_id',
        'title',
        'description',
        'text',
        'img',
        'likes',
        'dislikes',
        'views',
    ]);

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
