<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class FolderController extends Controller
{
     use AuthorizesRequests;

    // Liste des dossiers racine
    public function index()
    {
        $folders = Folder::where('user_id', auth()->id())
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return view('folders.index', compact('folders'));
    }

    // Afficher un dossier et son contenu
    public function show(Folder $folder)
    {
        $this->authorize('view', $folder);

        $folder->load('children', 'files');
        $breadcrumb = $this->getBreadcrumb($folder);

        return view('folders.show', compact('folder', 'breadcrumb'));
    }

    // Formulaire de création
    public function create(Request $request)
    {
        $parentId = $request->query('parent_id');
        $parent = $parentId ? Folder::findOrFail($parentId) : null;

        return view('folders.create', compact('parent'));
    }

    // Enregistrer un nouveau dossier
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        Folder::create([
            'name'      => $request->name,
            'user_id'   => auth()->id(),
            'parent_id' => $request->parent_id,
        ]);

        if ($request->parent_id) {
            return redirect()->route('folders.show', $request->parent_id)
                ->with('success', 'Dossier créé avec succès.');
        }

        return redirect()->route('folders.index')
            ->with('success', 'Dossier créé avec succès.');
    }

    // Formulaire de modification
    public function edit(Folder $folder)
    {
        $this->authorize('update', $folder);
        return view('folders.edit', compact('folder'));
    }

    // Mettre à jour le dossier
    public function update(Request $request, Folder $folder)
    {
        $this->authorize('update', $folder);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder->update(['name' => $request->name]);

        return redirect()->route('folders.index')
            ->with('success', 'Dossier renommé avec succès.');
    }

    // Supprimer un dossier
    public function destroy(Folder $folder)
    {
        $this->authorize('delete', $folder);
        $folder->delete();

        return redirect()->route('folders.index')
            ->with('success', 'Dossier supprimé.');
    }

    // Breadcrumb (fil d'ariane)
    private function getBreadcrumb(Folder $folder): array
    {
        $breadcrumb = [];
        $current = $folder;

        while ($current) {
            array_unshift($breadcrumb, $current);
            $current = $current->parent;
        }

        return $breadcrumb;
    }
}