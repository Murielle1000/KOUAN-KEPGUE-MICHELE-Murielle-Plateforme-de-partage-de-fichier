<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Folder extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id', 'parent_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Dossier parent
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    // Sous-dossiers
    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    // Fichiers dans ce dossier
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}