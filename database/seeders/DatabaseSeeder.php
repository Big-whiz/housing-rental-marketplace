<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\Message;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a Landlord User
        $landlord = User::create([
            'name' => 'Kofi Mensah',
            'email' => 'landlord@example.com',
            'phone' => '+233244123456',
            'role' => 'landlord',
            'is_verified' => true,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 2. Create a Tenant User
        $tenant = User::create([
            'name' => 'Ama Osei',
            'email' => 'tenant@example.com',
            'phone' => '+233200111222',
            'role' => 'tenant',
            'is_verified' => false,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create an Admin User
        $admin = User::create([
            'name' => 'Marketplace Admin',
            'email' => 'admin@example.com',
            'phone' => '+233244999999',
            'role' => 'admin',
            'is_verified' => true,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 3. Create realistic property listings in Accra
        $listing1 = Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Modern 2-Bedroom Apartment in East Legon',
            'description' => 'A spacious and fully furnished 2-bedroom apartment located in the serene environment of East Legon, Accra. Close to supermarkets, schools, and restaurants. Features 24/7 security, standby generator, and high-speed Wi-Fi.',
            'price' => 1200.00,
            'property_type' => 'Apartment',
            'bedrooms' => 2,
            'location' => 'East Legon, Accra',
            'latitude' => 5.632222,
            'longitude' => -0.160278,
            'photos' => [
                'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => true,
        ]);

        Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Cozy Single Room Studio in Osu',
            'description' => 'A neat and modern single-room self-contain studio apartment situated in the heart of Osu, Accra. Walking distance to Oxford Street, shopping malls, and vibrant nightlife. Ideal for single professionals.',
            'price' => 450.00,
            'property_type' => 'Studio',
            'bedrooms' => 1,
            'location' => 'Osu, Accra',
            'latitude' => 5.558333,
            'longitude' => -0.183333,
            'photos' => [
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => true,
        ]);

        Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Spacious 3-Bedroom Gated House',
            'description' => 'Beautiful 3-bedroom townhouse inside a secure gated community at Spintex, Accra. Features a spacious living area, modern kitchen fittings, pre-paid meter installed, water reservoir (polytank), and ample parking space.',
            'price' => 2000.00,
            'property_type' => 'House',
            'bedrooms' => 3,
            'location' => 'Spintex, Accra',
            'latitude' => 5.616667,
            'longitude' => -0.083333,
            'photos' => [
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => false,
        ]);

        Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Luxury 2-Bedroom Suite in Airport Residential Area',
            'description' => 'Experience premium living in the highly sought-after Airport Residential Area. This executive 2-bedroom features high-end European fittings, a swimming pool, access to a fully equipped gym, secure underground parking, and 24-hour concierge services.',
            'price' => 2500.00,
            'property_type' => 'Apartment',
            'bedrooms' => 2,
            'location' => 'Airport Residential Area, Accra',
            'latitude' => 5.6053,
            'longitude' => -0.1781,
            'photos' => [
                'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => true,
        ]);

        Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Executive 1-Bedroom Studio in Cantonments',
            'description' => 'Modern 1-bedroom studio located in a peaceful, upscale gated complex in Cantonments, Accra. Comes with a private balcony, swimming pool access, backup utilities, and tight security. Perfect for expats and corporate tenants.',
            'price' => 1800.00,
            'property_type' => 'Studio',
            'bedrooms' => 1,
            'location' => 'Cantonments, Accra',
            'latitude' => 5.5802,
            'longitude' => -0.1703,
            'photos' => [
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => true,
        ]);

        Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Beautiful 4-Bedroom Family Home in Labone',
            'description' => 'A grand 4-bedroom house with an outhouse boys quarters in Labone, Accra. Huge garden area, study room, separate dining area, backup solar panels, and water treatment system. Perfect for large families looking for space and comfort.',
            'price' => 3500.00,
            'property_type' => 'House',
            'bedrooms' => 4,
            'location' => 'Labone, Accra',
            'latitude' => 5.5684,
            'longitude' => -0.1654,
            'photos' => [
                'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => true,
        ]);

        Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Budget Friendly 1-Bedroom Apartment in Dzorwulu',
            'description' => 'Cozy 1-bedroom apartment located in Dzorwulu. Highly accessible to the highway, close to transport hubs and local food joints. Comes semi-furnished with a private kitchen and bathroom. Ideal for students or young professionals.',
            'price' => 900.00,
            'property_type' => 'Apartment',
            'bedrooms' => 1,
            'location' => 'Dzorwulu, Accra',
            'latitude' => 5.6094,
            'longitude' => -0.1983,
            'photos' => [
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => false,
        ]);

        Listing::create([
            'user_id' => $landlord->id,
            'title' => 'Charming 3-Bedroom House in Tesano',
            'description' => 'Classic 3-bedroom bungalow house in the serene neighborhood of Tesano, Accra. Offers large rooms, terrazzo floors, a large secure yard with trees, and parking for up to 3 cars. Excellent neighborhood security.',
            'price' => 1400.00,
            'property_type' => 'House',
            'bedrooms' => 3,
            'location' => 'Tesano, Accra',
            'latitude' => 5.5975,
            'longitude' => -0.2235,
            'photos' => [
                'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80',
            ],
            'is_verified' => true,
        ]);

        // 4. Seed a payment transaction
        Payment::create([
            'user_id' => $tenant->id,
            'listing_id' => $listing1->id,
            'amount' => 1200.00,
            'status' => 'completed',
            'transaction_reference' => 'PAY-MOMO-63E8A1F',
        ]);

        // 5. Seed an inquiry message
        Message::create([
            'sender_id' => $tenant->id,
            'receiver_id' => $landlord->id,
            'listing_id' => $listing1->id,
            'message' => 'Hello Kofi, I am interested in viewing the East Legon apartment tomorrow. Let me know if that works.',
        ]);
    }
}
