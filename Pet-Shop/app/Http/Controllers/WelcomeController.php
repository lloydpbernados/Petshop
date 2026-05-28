<?php
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/WelcomeController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Supply;
use App\Models\Service;

class WelcomeController extends Controller
{
    public function index()
    {
        // Featured pets shown in hero section (up to 4, random selection each visit)
        $featuredPets = Pet::where('available', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Essential supplies highlighted in the landing strip
        $essentialSupplies = Supply::where('available', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Featured products grid (8 items, ordered by badge importance)
        $featuredProducts = Supply::where('available', true)
            ->where('stock', '>', 0)
            ->orderByRaw("FIELD(badge, 'bestseller', 'popular', 'new', 'essential', 'fun', 'sale') ASC")
            ->take(8)
            ->get();

        // Services shown in the services section (active only, up to 3)
        $services = Service::where('status', 'Active')
            ->take(3)
            ->get();

        return view('welcome', compact(
            'featuredPets',
            'essentialSupplies',
            'featuredProducts',
            'services'
        ));
    }
}