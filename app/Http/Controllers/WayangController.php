<?php

namespace App\Http\Controllers;

use App\Models\WayangCategory;
use App\Models\WayangCharacter;
use Illuminate\Http\Request;

class WayangController extends Controller
{
    /**
     * Tampilkan Katalog Tokoh Pewayangan dengan Filter & Pencarian
     */
    public function index(Request $request)
    {
        $search     = $request->query('search');
        $categoryId = $request->query('category');
        $allegiance = $request->query('allegiance');

        $categories = WayangCategory::withCount('characters')->get();

        $query = WayangCharacter::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('other_names', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('character_traits', 'like', "%{$search}%")
                  ->orWhere('weapon', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($allegiance) {
            $query->where('allegiance', $allegiance);
        }

        $characters = $query->orderBy('id')->paginate(12)->withQueryString();

        $selectedCategory = $categoryId ? WayangCategory::find($categoryId) : null;
        $totalCharacters  = WayangCharacter::count();

        // Allegiance options for filter
        $allegiances = WayangCharacter::distinct('allegiance')->pluck('allegiance');

        return view('wayang.index', compact(
            'categories',
            'characters',
            'selectedCategory',
            'totalCharacters',
            'allegiances',
            'search',
            'categoryId',
            'allegiance'
        ));
    }

    /**
     * Tampilkan Detail Lengkap Tokoh Wayang
     */
    public function show(WayangCharacter $character)
    {
        $character->load('category');

        // Tokoh terkait dalam kategori yang sama
        $relatedCharacters = WayangCharacter::where('category_id', $character->category_id)
            ->where('id', '!=', $character->id)
            ->take(4)
            ->get();

        return view('wayang.show', compact('character', 'relatedCharacters'));
    }
}
