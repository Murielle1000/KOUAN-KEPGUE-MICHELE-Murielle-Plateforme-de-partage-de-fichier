<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicFilesController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Lien public (sans connexion requise)
Route::get('/shared/{token}', [FileController::class, 'shared'])->name('files.shared');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dossiers
    Route::resource('folders', FolderController::class);

    // Fichiers
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::get('/files/upload', [FileController::class, 'create'])->name('files.create');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    // Partage
    Route::post('/files/{file}/share', [FileController::class, 'share'])->name('files.share');
    Route::delete('/files/{file}/share', [FileController::class, 'revokeShare'])->name('files.revoke-share');
    
    // Logs de téléchargement
    Route::get('/files/{file}/logs', [FileController::class, 'logs'])->name('files.logs');

    // Fichiers publics
    Route::get('/files/public/{token}', [PublicFilesController::class, 'show'])->name('files.public.show');
    
    //Fichiers publics - téléchargement
    Route::get('/explore', [PublicFilesController::class, 'index'])->name('explore');

});

require __DIR__.'/auth.php';