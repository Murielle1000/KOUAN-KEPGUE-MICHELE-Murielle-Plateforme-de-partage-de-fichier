<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>📁 {{ $folder->name }}</h1>
            <nav class="fs-breadcrumb" style="margin-top:0.5rem;color:rgba(255,255,255,0.7);">
                <a href="{{ route('folders.index') }}" style="color:rgba(255,255,255,0.85);">Mes dossiers</a>
                @foreach($breadcrumb as $crumb)
                    <span class="sep">/</span>
                    <a href="{{ route('folders.show', $crumb) }}"
                       style="color:{{ $loop->last ? 'white' : 'rgba(255,255,255,0.85)' }};font-weight:{{ $loop->last ? '600' : '400' }};">
                        {{ $crumb->name }}
                    </a>
                @endforeach
            </nav>
        </div>
        <div style="display:flex;gap:0.75rem;">
            <a href="{{ route('folders.create', ['parent_id' => $folder->id]) }}"
               class="fs-btn" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:white;">
                + Sous-dossier
            </a>
            <a href="{{ route('files.create', ['folder_id' => $folder->id]) }}"
               class="fs-btn" style="background:rgba(255,255,255,0.25);border:1px solid rgba(255,255,255,0.4);color:white;">
                ⬆ Uploader
            </a>
        </div>
    </x-slot>

    <div class="fs-main">

        @if(session('success'))
            <div class="fs-alert fs-alert-success">✅ {{ session('success') }}</div>
        @endif

        {{-- Sous-dossiers --}}
        @if($folder->children->count() > 0)
            <div class="fs-card" style="margin-bottom:1.25rem;">
                <div class="fs-card-header">
                    <h3>Sous-dossiers</h3>
                    <span class="fs-badge fs-badge-info">{{ $folder->children->count() }}</span>
                </div>
                <div class="fs-card-body">
                    <div class="fs-folder-grid">
                        @foreach($folder->children as $child)
                            <div>
                                <a href="{{ route('folders.show', $child) }}" class="fs-folder-item">
                                    <div class="fs-folder-icon">📁</div>
                                    <div style="flex:1;min-width:0;">
                                        <div class="fs-folder-name">{{ $child->name }}</div>
                                        <div class="fs-folder-meta">{{ $child->files()->count() }} fichier(s)</div>
                                    </div>
                                </a>
                                <div style="display:flex;gap:0.4rem;margin-top:0.4rem;">
                                    <a href="{{ route('folders.edit', $child) }}" class="fs-btn fs-btn-ghost fs-btn-sm" style="flex:1;justify-content:center;">✏️</a>
                                    <form action="{{ route('folders.destroy', $child) }}" method="POST" onsubmit="return confirm('Supprimer ce sous-dossier ?')">
                                        @csrf @method('DELETE')
                                        <button class="fs-btn fs-btn-danger fs-btn-sm">🗑</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Fichiers --}}
        <div class="fs-card">
            <div class="fs-card-header">
                <h3>Fichiers</h3>
                <span class="fs-badge fs-badge-info">{{ $folder->files->count() }}</span>
            </div>
            <table class="fs-table">
                <thead>
                    <tr>
                        <th>Fichier</th>
                        <th>Taille</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($folder->files as $file)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    <div class="fs-file-icon {{ str_contains($file->mime_type,'image') ? 'fs-file-icon-image' : (str_contains($file->mime_type,'pdf') ? 'fs-file-icon-pdf' : 'fs-file-icon-default') }}">
                                        {{ str_contains($file->mime_type,'image') ? '🖼' : (str_contains($file->mime_type,'pdf') ? '📕' : '📄') }}
                                    </div>
                                    <span style="font-weight:500;">{{ Str::limit($file->original_name, 35) }}</span>
                                </div>
                            </td>
                            <td style="color:var(--gray-500);">{{ $file->formatted_size }}</td>
                            <td>
                                @if($file->is_public)
                                    <span class="fs-badge fs-badge-public">● Public</span>
                                @else
                                    <span class="fs-badge fs-badge-private">● Privé</span>
                                @endif
                            </td>
                            <td style="color:var(--gray-500);">{{ $file->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display:flex;gap:0.4rem;">
                                    <a href="{{ route('files.download', $file) }}" class="fs-btn fs-btn-ghost fs-btn-sm">⬇</a>
                                    @if($file->is_public)
                                        <form action="{{ route('files.revoke-share', $file) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="fs-btn fs-btn-ghost fs-btn-sm">🔒</button>
                                        </form>
                                    @else
                                        <form action="{{ route('files.share', $file) }}" method="POST">
                                            @csrf
                                            <button class="fs-btn fs-btn-secondary fs-btn-sm">🔗</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                        @csrf @method('DELETE')
                                        <button class="fs-btn fs-btn-danger fs-btn-sm">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:2.5rem;color:var(--gray-500);">
                                <div style="font-size:2rem;margin-bottom:0.5rem;">📄</div>
                                Aucun fichier dans ce dossier.
                                <a href="{{ route('files.create', ['folder_id' => $folder->id]) }}"
                                   style="color:var(--violet-600);display:block;margin-top:0.5rem;">
                                    Uploader maintenant →
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>