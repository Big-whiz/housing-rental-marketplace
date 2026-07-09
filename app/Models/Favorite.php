<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'listing_id'])]
class Favorite extends Model
{
    use HasFactory;

    /**
     * Get the user who marked this favorite.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the listing that was favorited.
     */
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
