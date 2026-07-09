<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    /**
     * Display the Tenant Dashboard containing favorites, messages, and MoMo payments.
     */
    public function dashboard()
    {
        // Enforce user check (redirect to login if not authenticated)
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login to access your tenant dashboard.']);
        }

        $user = Auth::user();

        // 1. Fetch listings favorited by this user
        $favorites = $user->favorites()->latest()->get();

        // 2. Fetch all messages sent by this tenant (inquiry threads)
        $messages = Message::where('sender_id', $user->id)
            ->with(['receiver', 'listing'])
            ->latest()
            ->get()
            ->groupBy('listing_id'); // Group inquiries by the property context

        // 3. Fetch payment history (deposits/viewing fees)
        $payments = Payment::where('user_id', $user->id)
            ->with(['listing'])
            ->latest()
            ->get();

        return view('tenant-dashboard', compact('favorites', 'messages', 'payments'));
    }

    /**
     * Display a list of all favorited property listings for the logged-in user.
     */
    public function favoritesList()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['auth' => 'Please login to view your favorite listings.']);
        }

        $listings = Auth::user()->favorites()->latest()->get();

        return view('favorites', compact('listings'));
    }
}
