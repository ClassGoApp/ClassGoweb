<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $fillable = ['name'];
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag_links', 'tag_id', 'blog_id');
    }
}
