<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'bio',
        'avatar',
        'cv_url',
        'email',
        'github_url',
        'linkedin_url',
        'is_dark_mode_default'
    ];

    protected $appends = ['full_cv_url', 'avatar_url'];

    protected function fullCvUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cv_url ? url('storage/' . $this->cv_url) : null,
        );
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->avatar ? url('storage/' . $this->avatar) : null,
        );
    }
}
