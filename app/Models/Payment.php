<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'listing_id', 'amount', 'status', 'transaction_reference'])]
class Payment extends Model
{
    use HasFactory;

    /**
     * Get the user who paid.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the listing that the payment was for.
     */
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
