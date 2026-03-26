<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicFilesController extends Controller
{
    public function index(Request $request)
    {
        $query = File::with('user')
            ->where('is_public', true)
            ->whereNotNull('share_token');

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('mime_type', 'like', '%' . $request->type . '%');
        }

        // Filtre par utilisateur
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        $files = $query->latest()->paginate(20)->withQueryString();

        // Statistiques
        $totalPublic  = File::where('is_public', true)->count();
        $totalUsers   = File::where('is_public', true)
                            ->distinct('user_id')
                            ->count('user_id');
        $totalSize    = File::where('is_public', true)->sum('size');

        return view('explore', compact(
            'files',
            'totalPublic',
            'totalUsers',
            'totalSize'
        ));
    }
}