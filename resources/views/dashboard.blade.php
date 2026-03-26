<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Bonjour, {{ auth()->user()->name }} 👋</h1>
            <p>Bienvenue sur votre espace de partage de fichiers</p>
        </div>
        <a href="{{ route('files.create') }}" class="fs-btn fs-btn-primary" style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);">
            ⬆ Uploader
        </a>
    </x-slot>

    <div class="fs-main">

        {{-- Stats --}}
        <div class="fs-stats">
            <div class="fs-stat">
                <div class="fs-stat-icon">📁</div>
                <div>
                    <div class="fs-stat-value">{{ auth()->user()->folders()->count() }}</div>
                    <div class="fs-stat-label">Dossiers</div>
                </div>
            </div>
            <div class="fs-stat">
                <div class="fs-stat-icon">📄</div>
                <div>
                    <div class="fs-stat-value">{{ auth()->user()->files()->count() }}</div>
                    <div class="fs-stat-label">Fichiers</div>
                </div>
            </div>
            <div class="fs-stat">
                <div class="fs-stat-icon">🔗</div>
                <div>
                    <div class="fs-stat-value">{{ auth()->user()->files()->where('is_public', true)->count() }}</div>
                    <div class="fs-stat-label">Partagés</div>
                </div>
            </div>
            <div class="fs-stat">
                <div class="fs-stat-icon">💾</div>
                <div>
                    <div class="fs-stat-value">{{ number_format(auth()->user()->files()->sum('size') / 1048576, 1) }}</div>
                    <div class="fs-stat-label">MB utilisés</div>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

            {{-- Actions rapides --}}
            <div class="fs-card">
                <div class="fs-card-header">
                    <h3>Actions rapides</h3>
                </div>
                <div class="fs-card-body" style="display:flex;flex-direction:column;gap:0.75rem;">
                    <a href="{{ route('files.create') }}" class="fs-btn fs-btn-primary" style="justify-content:center;padding:0.85rem;">
                        ⬆ Uploader un fichier
                    </a>
                    <a href="{{ route('folders.create') }}" class="fs-btn fs-btn-secondary" style="justify-content:center;padding:0.85rem;">
                        📁 Créer un dossier
                    </a>
                    <a href="{{ route('files.index') }}" class="fs-btn fs-btn-ghost" style="justify-content:center;padding:0.85rem;">
                        🔍 Rechercher un fichier
                    </a>
                    <a href="{{ route('explore') }}"
                        class="fs-btn fs-btn-ghost"
                        style="justify-content:center;padding:0.85rem;">
                        🌐 Explorer les fichiers publics
                    </a>
                </div>
            </div>

            {{-- Fichiers récents --}}
            <div class="fs-card">
                <div class="fs-card-header">
                    <h3>Fichiers récents</h3>
                    <a href="{{ route('files.index') }}" class="fs-btn fs-btn-ghost fs-btn-sm">Voir tout →</a>
                </div>
                <div>
                    @php $recentFiles = auth()->user()->files()->latest()->take(5)->get(); @endphp
                    @forelse($recentFiles as $file)
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:0.85rem 1.5rem;border-bottom:1px solid var(--gray-100);">
                            <div style="display:flex;align-items:center;gap:0.75rem;">
                                <div class="fs-file-icon {{ str_contains($file->mime_type,'image') ? 'fs-file-icon-image' : (str_contains($file->mime_type,'pdf') ? 'fs-file-icon-pdf' : 'fs-file-icon-default') }}">
                                    {{ str_contains($file->mime_type,'image') ? '🖼' : (str_contains($file->mime_type,'pdf') ? '📕' : '📄') }}
                                </div>
                                <div>
                                    <div style="font-size:0.875rem;font-weight:500;color:var(--gray-900);">{{ Str::limit($file->original_name, 28) }}</div>
                                    <div style="font-size:0.75rem;color:var(--gray-500);">{{ $file->formatted_size }} • {{ $file->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <a href="{{ route('files.download', $file) }}" class="fs-btn fs-btn-ghost fs-btn-sm">⬇</a>
                        </div>
                    @empty
                        <div style="padding:2rem;text-align:center;color:var(--gray-500);font-size:0.875rem;">Aucun fichier récent</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Dossiers --}}
        <div class="fs-card" style="margin-top:1.25rem;">
            <div class="fs-card-header">
                <h3>Mes dossiers</h3>
                <a href="{{ route('folders.index') }}" class="fs-btn fs-btn-ghost fs-btn-sm">Voir tout →</a>
            </div>
            <div class="fs-card-body">
                @php $recentFolders = auth()->user()->folders()->whereNull('parent_id')->latest()->take(6)->get(); @endphp
                <div class="fs-folder-grid">
                    @forelse($recentFolders as $folder)
                        <a href="{{ route('folders.show', $folder) }}" class="fs-folder-item">
                            <div class="fs-folder-icon">📁</div>
                            <div>
                                <div class="fs-folder-name">{{ $folder->name }}</div>
                                <div class="fs-folder-meta">{{ $folder->files()->count() }} fichier(s)</div>
                            </div>
                        </a>
                    @empty
                        <p style="color:var(--gray-500);font-size:0.875rem;">Aucun dossier créé.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-app-layout>