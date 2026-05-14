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
                'name'     => 'Golden Retriever',
                'category' => 'Dogs',
                'price'    => '₱12,500',
                'badge'    => 'Popular',
                'emoji'    => '🐕',
                'desc'     => 'Friendly, loyal & great with families.',
            ],
            [
                'name'     => 'Persian Cat',
                'category' => 'Cats',
                'price'    => '₱8,000',
                'badge'    => 'New',
                'emoji'    => '🐈',
                'desc'     => 'Calm, gentle & incredibly fluffy.',
            ],
            [
                'name'     => 'Holland Lop',
                'category' => 'Rabbits',
                'price'    => '₱3,200',
                'badge'    => 'Sale',
                'emoji'    => '🐇',
                'desc'     => 'Compact, sociable & super cuddly.',
            ],
            [
                'name'     => 'African Grey',
                'category' => 'Birds',
                'price'    => '₱22,000',
                'badge'    => 'Rare',
                'emoji'    => '🦜',
                'desc'     => 'Intelligent, talkative & affectionate.',
            ],
        ];

        $services = [
            ['icon' => '✂️', 'title' => 'Pet Grooming',    'desc' => 'Full bath, trim & spa treatments for your beloved pet.'],
            ['icon' => '🏥', 'title' => 'Veterinary Care', 'desc' => 'In-house vet consultations, vaccines & health check-ups.'],
            ['icon' => '🏠', 'title' => 'Pet Boarding',    'desc' => 'Safe, cozy overnight stays while you\'re away.'],
            ['icon' => '🎓', 'title' => 'Pet Training',    'desc' => 'Professional obedience & behavioral training sessions.'],
            ['icon' => '🛒', 'title' => 'Pet Supplies',    'desc' => 'Premium food, toys, accessories & wellness products.'],
            ['icon' => '🚗', 'title' => 'Pet Transport',   'desc' => 'Safe door-to-door delivery & pickup services.'],
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