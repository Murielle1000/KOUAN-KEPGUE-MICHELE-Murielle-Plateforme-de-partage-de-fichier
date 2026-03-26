<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Mes fichiers</h1>
            <p>Tous vos fichiers en un seul endroit</p>
        </div>
        <a href="{{ route('files.create') }}" class="fs-btn" style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);color:white;">
            ⬆ Uploader
        </a>
    </x-slot>

    <div class="fs-main">

        @if(session('success'))
            <div class="fs-alert fs-alert-success">✅ {{ session('success') }}</div>
        @endif

        @if(session('share_url'))
            <div class="fs-alert fs-alert-info">
                <div style="flex:1;">
                    <strong>🔗 Lien de partage :</strong>
                    <div style="display:flex;gap:0.5rem;margin-top:0.5rem;">
                        <input type="text" value="{{ session('share_url') }}" class="fs-input" readonly onclick="this.select()" style="font-size:0.8rem;">
                        <button onclick="navigator.clipboard.writeText('{{ session('share_url') }}')" class="fs-btn fs-btn-primary fs-btn-sm">Copier</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Recherche --}}
        <div class="fs-card" style="margin-bottom:1.25rem;">
            <div class="fs-card-body">
                <form action="{{ route('files.index') }}" method="GET" style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end;">
                    <div style="flex:1;min-width:200px;">
                        <label class="fs-label">Rechercher</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="fs-input" placeholder="Nom du fichier...">
                    </div>
                    <div style="min-width:160px;">
                        <label class="fs-label">Type</label>
                        <select name="type" class="fs-input fs-select">
                            <option value="">Tous les types</option>
                            <option value="image" {{ request('type')=='image'?'selected':'' }}>🖼 Images</option>
                            <option value="pdf"   {{ request('type')=='pdf'?'selected':'' }}>📕 PDF</option>
                            <option value="video" {{ request('type')=='video'?'selected':'' }}>🎬 Vidéos</option>
                            <option value="audio" {{ request('type')=='audio'?'selected':'' }}>🎵 Audio</option>
                            <option value="zip"   {{ request('type')=='zip'?'selected':'' }}>🗜 Archives</option>
                        </select>
                    </div>
                    <div style="display:flex;gap:0.5rem;">
                        <button type="submit" class="fs-btn fs-btn-primary">🔍 Rechercher</button>
                        @if(request('search') || request('type'))
                            <a href="{{ route('files.index') }}" class="fs-btn fs-btn-ghost">✕</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="fs-card">
            <div class="fs-table-wrapper">

                <table class="fs-table">
                    <thead>
                        <tr>
                            <th>Fichier</th>
                            <th>Taille</th>
                            <th>Dossier</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
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
                                <td style="color:var(--gray-500);">{{ $file->folder?->name ?? '—' }}</td>
                                <td>
                                    @if($file->is_public)
                                        <span class="fs-badge fs-badge-public">● Public</span>
                                    @else
                                        <span class="fs-badge fs-badge-private">● Privé</span>
                                    @endif
                                </td>
                                <td style="color:var(--gray-500);">{{ $file->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
                                        <a href="{{ route('files.download', $file) }}" class="fs-btn fs-btn-ghost fs-btn-sm">⬇</a>
                                        <a href="{{ route('files.logs', $file) }}" class="fs-btn fs-btn-ghost fs-btn-sm">📋</a>
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
                                <td colspan="6" style="text-align:center;padding:3rem;color:var(--gray-500);">
                                    <div style="font-size:2.5rem;margin-bottom:0.75rem;">📄</div>
                                    Aucun fichier. <a href="{{ route('files.create') }}" style="color:var(--violet-600);">Uploader le premier</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>    
            <div style="padding:1rem 1.5rem;">{{ $files->links() }}</div>
        </div>
    </div>
</x-app-layout>