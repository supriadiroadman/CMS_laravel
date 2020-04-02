<?php

namespace App;

use App\Tag;
use App\User;
use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    // protected $dates = ['published_at'];

    protected $fillable = ['title', 'description', 'content', 'image', 'published_at', 'category_id', 'user_id'];

    // Method hapus image (digunakan di PostController)
    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function hasTag($tagId)
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function scopePublished($kuery)
    // {
    //     return $kuery->where('published_at', '<=', now());
    // }
}
