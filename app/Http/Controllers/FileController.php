<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Models\DownloadLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FileController extends Controller
{
    use AuthorizesRequests;

    // Formulaire d'upload
    public function create(Request $request)
    {
        $folderId = $request->query('folder_id');
        $folder = $folderId ? Folder::findOrFail($folderId) : null;

        return view('files.create', compact('folder'));
    }

    // Enregistrer le fichier uploadé
    public function store(Request $request)
    {
        $request->validate([
            'file'      => [
                'required',
                'file',
                'max:51200', // 50MB
                'mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,mp4,mp3',
            ],
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $uploadedFile = $request->file('file');

        // Stocker le fichier dans storage/app/private/uploads
        $path = $uploadedFile->store('uploads', 'private');

        File::create([
            'name'          => pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME),
            'original_name' => $uploadedFile->getClientOriginalName(),
            'path'          => $path,
            'mime_type'     => $uploadedFile->getMimeType(),
            'size'          => $uploadedFile->getSize(),
            'user_id'       => auth()->id(),
            'folder_id'     => $request->folder_id,
            'is_public'     => false,
        ]);

        if ($request->folder_id) {
            return redirect()->route('folders.show', $request->folder_id)
                ->with('success', 'Fichier uploadé avec succès.');
        }

        return redirect()->route('files.index')
            ->with('success', 'Fichier uploadé avec succès.');
    }

    // Liste de tous les fichiers de l'utilisateur
    public function index(Request $request)
    {
        $query = File::where('user_id', auth()->id())->latest();

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('mime_type', 'like', '%' . $request->type . '%');
        }

        $files = $query->paginate(20)->withQueryString();

        return view('files.index', compact('files'));
    }

    // Télécharger un fichier
    public function download(File $file)
    {
        $this->authorize('view', $file);

        // Enregistrer dans l'historique
        DownloadLog::create([
            'file_id'          => $file->id,
            'user_id'          => auth()->id(),
            'ip_address'       => request()->ip(),
            'user_agent'       => request()->userAgent(),
            'is_public_access' => false,
        ]);

        return Storage::disk('private')->download(
            $file->path,
            $file->original_name
        );
    }

    // Supprimer un fichier
    public function destroy(File $file)
    {
        $this->authorize('delete', $file);

        Storage::disk('private')->delete($file->path);
        $file->delete();

        return back()->with('success', 'Fichier supprimé.');
    }

        // Générer ou récupérer le lien de partage
    public function share(File $file)
    {
        $this->authorize('update', $file);

        if (!$file->share_token) {
            $file->update([
                'share_token' => Str::random(32),
                'is_public'   => true,
            ]);
        }

        $shareUrl = route('files.shared', $file->share_token);

        return back()->with('share_url', $shareUrl);
    }

    // Accéder à un fichier via lien public
    public function shared(string $token)
    {
        $file = File::where('share_token', $token)
            ->where('is_public', true)
            ->firstOrFail();

        // Enregistrer dans l'historique (accès public)
        DownloadLog::create([
            'file_id'          => $file->id,
            'user_id'          => null,
            'ip_address'       => request()->ip(),
            'user_agent'       => request()->userAgent(),
            'is_public_access' => true,
        ]);

        return Storage::disk('private')->download(
            $file->path,
            $file->original_name
        );
    }

    // Révoquer le lien de partage
    public function revokeShare(File $file)
    {
        $this->authorize('update', $file);

        $file->update([
            'share_token' => null,
            'is_public'   => false,
        ]);

        return back()->with('success', 'Lien de partage révoqué.');
    }

    // Afficher l'historique des téléchargements d'un fichier
    public function logs(File $file)
    {
        $this->authorize('update', $file);

        $logs = $file->downloadLogs()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('files.logs', compact('file', 'logs'));
    }
}