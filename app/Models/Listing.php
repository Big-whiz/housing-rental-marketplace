<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Cast;

#[Fillable([
    'user_id',
    'title',
    'description',
    'price',
    'property_type',
    'bedrooms',
    'location',
    'latitude',
    'longitude',
    'photos',
    'is_verified'
])]
class Listing extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'photos' => 'array', // Automatically cast JSON list to PHP array
            'is_verified' => 'boolean',
            'price' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    /**
     * Get the user (landlord) who created this listing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all users who favorited this listing.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * Get the messages sent regarding this listing.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the payments associated with this listing.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
