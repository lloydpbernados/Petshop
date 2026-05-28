<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Supply;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Display the public landing / welcome page.
     * Route: GET /   (name: home)
     */
    public function index()
    {
        // Up to 4 random available pets for the hero section
        $featuredPets = Pet::where('available', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 8 available supplies sorted by badge importance for the grid
        $featuredProducts = Supply::where('available', true)
            ->where('stock', '>', 0)
            ->orderByRaw("FIELD(badge, 'bestseller', 'popular', 'new', 'essential', 'fun', 'sale') ASC")
            ->take(8)
            ->get();

        // Up to 3 active services for the services section
        $services = Service::where('status', 'Active')->take(3)->get();

        return view('welcome', compact(
            'featuredPets',
            'featuredProducts',
            'services'
        ));
    }
}