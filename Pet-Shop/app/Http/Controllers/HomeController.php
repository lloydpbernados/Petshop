<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        $featuredPets = [
            [
                'id'       => 1,  // ← ADD ID matching shop catalog
                'name'     => 'Golden Retriever',
                'category' => 'Dogs',
                'price'    => '₱12,500',
                'badge'    => 'Popular',
                'emoji'    => '🐕',
                'desc'     => 'Friendly, loyal & great with families.',
            ],
            [
                'id'       => 2,  // ← ADD ID
                'name'     => 'Persian Cat',
                'category' => 'Cats',
                'price'    => '₱8,000',
                'badge'    => 'New',
                'emoji'    => '🐈',
                'desc'     => 'Calm, gentle & incredibly fluffy.',
            ],
            [
                'id'       => 3,  // ← ADD ID
                'name'     => 'Holland Lop',
                'category' => 'Rabbits',
                'price'    => '₱3,200',
                'badge'    => 'Sale',
                'emoji'    => '🐇',
                'desc'     => 'Compact, sociable & super cuddly.',
            ],
            [
                'id'       => 5,  // ← ADD ID (skip 4 if not featured)
                'name'     => 'African Grey',
                'category' => 'Birds',
                'price'    => '₱22,000',
                'badge'    => 'Rare',
                'emoji'    => '🦜',
                'desc'     => 'Intelligent, talkative & affectionate.',
            ],
        ];

        // 🔧 SERVICES: Added 'id' matching shop.blade.php catalog (IDs 25-28)
        $services = [
            [
                'id'    => 25,  // ← MATCHES shop catalog ID for Full Pet Grooming
                'icon'  => '✂️', 
                'title' => 'Pet Grooming',    
                'desc'  => 'Full bath, trim & spa treatments for your beloved pet.',
            ],
            [
                'id'    => 26,  // ← MATCHES shop catalog ID for Basic Vet Checkup
                'icon'  => '🏥', 
                'title' => 'Veterinary Care', 
                'desc'  => 'In-house vet consultations, vaccines & health check-ups.',
            ],
            [
                'id'    => 27,  // ← MATCHES shop catalog ID for Overnight Boarding
                'icon'  => '🏠', 
                'title' => 'Pet Boarding',    
                'desc'  => 'Safe, cozy overnight stays while you\'re away.',
            ],
            [
                'id'    => 28,  // ← MATCHES shop catalog ID for Obedience Training
                'icon'  => '🎓', 
                'title' => 'Pet Training',    
                'desc'  => 'Professional obedience & behavioral training sessions.',
            ],
            // Optional: Remove or add IDs for these if they exist in your shop catalog
            // ['icon' => '🛒', 'title' => 'Pet Supplies', 'desc' => '...'],
            // ['icon' => '🚗', 'title' => 'Pet Transport', 'desc' => '...'],
        ];

        $testimonials = [
            [
                'name'   => 'Maria Santos',
                'role'   => 'Dog Mom',
                'quote'  => 'PawHaven is the only place I trust with my fur babies. The grooming service is absolutely top-notch!',
                'avatar' => 'MS',
                'stars'  => 5,
            ],
            [
                'name'   => 'Juan dela Cruz',
                'role'   => 'Cat Parent',
                'quote'  => 'I found my Persian kitten here and the staff was incredibly helpful and knowledgeable. Highly recommend!',
                'avatar' => 'JD',
                'stars'  => 5,
            ],
            [
                'name'   => 'Ana Reyes',
                'role'   => 'Bird Enthusiast',
                'quote'  => 'Amazing selection of birds and the vet consultations gave me so much peace of mind. 10/10 experience!',
                'avatar' => 'AR',
                'stars'  => 5,
            ],
        ];

        return view('welcome', compact('featuredPets', 'services', 'testimonials'));
    }
}