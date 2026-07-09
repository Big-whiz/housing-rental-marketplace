<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the properties, with optional search filters.
     */
    public function index(Request $request)
    {
        // Start building a query on the Listing model
        $query = Listing::query();

        // Filter by location search query (e.g. Accra neighborhood)
        if ($request->filled('search')) {
            $query->where('location', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
        }

        // Filter by property type (e.g., Apartment, House, Studio)
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Filter by number of bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', $request->bedrooms);
        }

        // Filter by minimum price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filter by maximum price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Get matching listings and order by latest uploaded
        $listings = $query->latest()->get();

        // Return the blade view with the filtered listings
        return view('listing', compact('listings'));
    }

    /**
     * Display the details of a single property listing.
     */
    public function show($id)
    {
        // Find the listing by its primary key id or fail with a 404 error page
        $listing = Listing::with('user')->findOrFail($id);

        // Fetch all in-app chat messages for this specific listing
        $messages = \App\Models\Message::where('listing_id', $id)
            ->with(['sender'])
            ->oldest() // Sort messages so older ones appear first in the chat bubble thread
            ->get();

        return view('listing-detail', compact('listing', 'messages'));
    }

    /**
     * Store a new in-app chat message between tenant and landlord.
     */
    public function sendMessage(Request $request, $id)
    {
        // Validate the input message
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $listing = Listing::findOrFail($id);

        // Retrieve logged-in user or fall back to seeded tenant Ama Osei for demo ease
        $sender = auth()->user() ?? \App\Models\User::where('role', 'tenant')->first();

        // Save the message into the database
        \App\Models\Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $listing->user_id, // Landlord who owns the listing
            'listing_id' => $listing->id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully!');
    }

    /**
     * Display the landlord dashboard with listings, incoming inquiries, and payments.
     */
    public function landlordDashboard()
    {
        // Default to logged-in user or seeded landlord Kofi Mensah
        $landlord = auth()->user() ?? \App\Models\User::where('role', 'landlord')->first();

        // Get listings owned by this landlord
        $listings = Listing::where('user_id', $landlord->id)->latest()->get();

        // Get all inquiries (messages) sent to this landlord
        $messages = \App\Models\Message::where('receiver_id', $landlord->id)
            ->with(['sender', 'listing'])
            ->latest()
            ->get();

        // Get all payment transactions made for these listings
        $payments = \App\Models\Payment::whereIn('listing_id', $listings->pluck('id'))
            ->with(['user', 'listing'])
            ->latest()
            ->get();

        return view('landlord-dashboard', compact('listings', 'messages', 'payments'));
    }

    /**
     * Handle property listing creation form submission with real photo uploads.
     */
    public function storeListing(Request $request)
    {
        // Validate details and photo files (maximum 3 files)
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'property_type' => 'required|string',
            'bedrooms' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'required|array|min:1|max:3',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120', // max 5MB per file
        ]);

        // Default to logged-in user or seeded landlord Kofi Mensah
        $landlord = auth()->user() ?? \App\Models\User::where('role', 'landlord')->first();

        // Handle File Uploads
        $uploadedPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Generate a human-readable unique filename
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // Move file directly into public/uploads/listings for simplicity
                $file->move(public_path('uploads/listings'), $filename);
                // Save the path to store in the database
                $uploadedPaths[] = '/uploads/listings/' . $filename;
            }
        }

        // Save listing to database
        Listing::create([
            'user_id' => $landlord->id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'property_type' => $request->property_type,
            'bedrooms' => $request->bedrooms,
            'location' => $request->location,
            'photos' => $uploadedPaths,
            'is_verified' => false, // New listings require admin approval
        ]);

        return redirect()->route('landlord.dashboard')->with('success', 'Property listing created and submitted for verification!');
    }

    /**
     * Delete a listing.
     */
    public function deleteListing($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('landlord.dashboard')->with('success', 'Listing deleted successfully.');
    }

    /**
     * Add or remove a listing from the authenticated user's favorites list.
     */
    public function toggleFavorite($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['auth' => 'You must login to favorite properties.']);
        }

        $user = auth()->user();
        $listing = Listing::findOrFail($id);

        // Toggle many-to-many relationship using pivot table
        $user->favorites()->toggle($listing->id);

        return back()->with('success', 'Favorites updated!');
    }

    /**
     * Process simulated Mobile Money (MoMo) payments.
     */
    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'momo_phone' => 'required|string|max:20',
            'network' => 'required|in:MTN,Vodafone,AirtelTigo',
            'amount' => 'required|numeric|min:1',
        ]);

        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['auth' => 'You must login to complete payments.']);
        }

        $user = auth()->user();
        $listing = Listing::findOrFail($id);

        // Record the transaction inside the database
        \App\Models\Payment::create([
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'amount' => $request->amount,
            'status' => 'completed', // Direct simulation success
            'transaction_reference' => 'PAY-MOMO-' . strtoupper(uniqid())
        ]);

        return redirect()->route('tenant.dashboard')->with('success', 'Mobile Money payment of GHS ' . number_format($request->amount) . ' completed successfully!');
    }
}
