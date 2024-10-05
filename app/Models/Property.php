<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location_id', 'description', 'price', 'type', 'status',
        'bedrooms', 'bathrooms', 'square_feet', 'images', 'listed_by', 'is_verified'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_verified' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function listedBy()
    {
        return $this->belongsTo(User::class, 'listed_by');
    }
}
