<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = ['name', 'slug', 'picture', 'description'];
    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($location) {
            // Create slug from the name
            $location->slug = $location->slug ?: Str::slug($location->name);
        });

        static::updating(function ($location) {
            // Update the slug if the name is changed
            if ($location->isDirty('name') && !$location->isDirty('slug')) {
                $location->slug = Str::slug($location->name);
            }
        });
    }
}
