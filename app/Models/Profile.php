<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'profile_picture',
        'bio',
        'location',
        'website',
        'social_links',
        'instagram_link',
        'date_of_birth',
        'experience_level',
        'languages_spoken',
        'average_rating',
        'total_reviews',
        'contact_preference',
        'availability',
        'detailed_bio',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
