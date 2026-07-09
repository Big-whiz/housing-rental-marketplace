<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard showing listing approval queue.
     */
    public function dashboard()
    {
        // Enforce basic admin access (simulated for MVP demo, or check role)
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->withErrors(['auth' => 'Access denied. Admin portal only.']);
        }

        // Fetch all listings ordered by latest uploaded
        $listings = Listing::with('user')->latest()->get();

        return view('admin-dashboard', compact('listings'));
    }

    /**
     * Approve and verify a listing.
     */
    public function approveListing($id)
    {
        $listing = Listing::findOrFail($id);
        
        // Toggle/Set verification to true
        $listing->is_verified = true;
        $listing->save();

        return back()->with('success', 'Listing verified and approved successfully!');
    }
}
