<?php

namespace App\Models;

use App\Events\PostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setTags($tagString)
    {
        if ($tagString) {
            $tagsToAttach = array_unique(array_map('trim', explode(',', $tagString)));
            foreach ($tagsToAttach as $tagName) {
                $tag = Tag::firstOrCreate([
                    'name' => $tagName,
                ]);
                $this->tags()->attach($tag->id);
            }
        }

    }

}
