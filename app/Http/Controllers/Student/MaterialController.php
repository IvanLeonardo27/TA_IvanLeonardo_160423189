<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with('category')->where('status', 'published');
        
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $materials = $query->latest()->paginate(12);
        $categories = MaterialCategory::all();

        return view('student.materials.index', compact('materials', 'categories'));
    }

    public function show(Material $material)
    {
        if ($material->status !== 'published') {
            abort(404);
        }

        $material->load(['category', 'unggahUngguhBasas', 'attachments']);
        return view('student.materials.show', compact('material'));
    }
}
