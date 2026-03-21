<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image_path',
        'github_url',
        'demo_url',
        'is_featured',
        'order',
    ];

    protected $appends = ['image_url'];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_path ? url('storage/' . $this->image_path) : null,
        );
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
