<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>🌐 Explorer</h1>
            <p>Fichiers partagés par la communauté</p>
        </div>
    </x-slot>

    <div class="fs-main">

        {{-- Statistiques --}}
        <div class="fs-stats" style="margin-bottom:1.25rem;">
            <div class="fs-stat">
                <div class="fs-stat-icon">🌐</div>
                <div>
                    <div class="fs-stat-value">{{ $totalPublic }}</div>
                    <div class="fs-stat-label">Fichiers publics</div>
                </div>
            </div>
            <div class="fs-stat">
                <div class="fs-stat-icon">👥</div>
                <div>
                    <div class="fs-stat-value">{{ $totalUsers }}</div>
                    <div class="fs-stat-label">Contributeurs</div>
                </div>
            </div>
            <div class="fs-stat">
                <div class="fs-stat-icon">💾</div>
                <div>
                    <div class="fs-stat-value">
                        {{ number_format($totalSize / 1048576, 1) }}
                    </div>
                    <div class="fs-stat-label">MB partagés</div>
                </div>
            </div>
        </div>

        {{-- Recherche & Filtres --}}
        <div class="fs-card" style="margin-bottom:1.25rem;">
            <div class="fs-card-body">
                <form action="{{ route('explore') }}" method="GET"
                      style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end;">

                    <div style="flex:1;min-width:160px;">
                        <label class="fs-label">Rechercher un fichier</label>
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               class="fs-input"
                               placeholder="Nom du fichier...">
                    </div>

                    <div style="min-width:150px;">
                        <label class="fs-label">Type de fichier</label>
                        <select name="type" class="fs-input fs-select">
                            <option value="">Tous les types</option>
                            <option value="image" {{ request('type')=='image'?'selected':'' }}>
                                🖼 Images
                            </option>
                            <option value="pdf" {{ request('type')=='pdf'?'selected':'' }}>
                                📕 PDF
                            </option>
                            <option value="video" {{ request('type')=='video'?'selected':'' }}>
                                🎬 Vidéos
                            </option>
                            <option value="audio" {{ request('type')=='audio'?'selected':'' }}>
                                🎵 Audio
                            </option>
                            <option value="zip" {{ request('type')=='zip'?'selected':'' }}>
                                🗜 Archives
                            </option>
                        </select>
                    </div>

                    <div style="min-width:150px;">
                        <label class="fs-label">Partagé par</label>
                        <input type="text" name="user"
                               value="{{ request('user') }}"
                               class="fs-input"
                               placeholder="Nom d'utilisateur...">
                    </div>

                    <div style="display:flex;gap:0.5rem;">
                        <button type="submit" class="fs-btn fs-btn-primary">
                            🔍 Filtrer
                        </button>
                        @if(request('search') || request('type') || request('user'))
                            <a href="{{ route('explore') }}"
                               class="fs-btn fs-btn-ghost">
                                ✕ Effacer
                            </a>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        {{-- Résultats actifs --}}
        @if(request('search') || request('type') || request('user'))
            <div class="fs-alert fs-alert-info" style="margin-bottom:1rem;">
                🔍 {{ $files->total() }} résultat(s) trouvé(s)
                @if(request('search')) pour "<strong>{{ request('search') }}</strong>"@endif
                @if(request('type')) · type : <strong>{{ request('type') }}</strong>@endif
                @if(request('user')) · par : <strong>{{ request('user') }}</strong>@endif
            </div>
        @endif

        {{-- Liste des fichiers --}}
        <div class="fs-card">
            <div class="fs-card-header">
                <h3>Fichiers disponibles</h3>
                <span class="fs-badge fs-badge-info">
                    {{ $files->total() }} fichier(s)
                </span>
            </div>

            <div class="fs-table-wrapper">
                <table class="fs-table">
                    <thead>
                        <tr>
                            <th>Fichier</th>
                            <th>Partagé par</th>
                            <th>Type</th>
                            <th>Taille</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.75rem;">
                                        <div class="fs-file-icon
                                            {{ str_contains($file->mime_type,'image') ? 'fs-file-icon-image'
                                            : (str_contains($file->mime_type,'pdf') ? 'fs-file-icon-pdf'
                                            : (str_contains($file->mime_type,'video') ? 'fs-file-icon-video'
                                            : (str_contains($file->mime_type,'audio') ? 'fs-file-icon-audio'
                                            : (str_contains($file->mime_type,'zip') ? 'fs-file-icon-zip'
                                            : 'fs-file-icon-default')))) }}">
                                            {{ str_contains($file->mime_type,'image') ? '🖼'
                                            : (str_contains($file->mime_type,'pdf') ? '📕'
                                            : (str_contains($file->mime_type,'video') ? '🎬'
                                            : (str_contains($file->mime_type,'audio') ? '🎵'
                                            : (str_contains($file->mime_type,'zip') ? '🗜'
                                            : '📄')))) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:500;color:var(--gray-900);">
                                                {{ Str::limit($file->original_name, 30) }}
                                            </div>
                                            <div style="font-size:0.75rem;color:var(--gray-500);">
                                                {{ $file->mime_type }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div style="display:flex;align-items:center;gap:0.6rem;">
                                        <div style="
                                            width: 30px; height: 30px;
                                            border-radius: 50%;
                                            background: var(--violet-500);
                                            color: white;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 0.75rem;
                                            font-weight: 600;
                                            flex-shrink: 0;
                                        ">
                                            {{ strtoupper(substr($file->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-size:0.875rem;font-weight:500;
                                                        color:var(--gray-900);">
                                                {{ $file->user->name }}
                                            </div>
                                            @if($file->user_id === auth()->id())
                                                <div style="font-size:0.7rem;color:var(--violet-500);">
                                                    (vous)
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="fs-badge fs-badge-info">
                                        {{ explode('/', $file->mime_type)[0] }}
                                    </span>
                                </td>

                                <td style="color:var(--gray-500);white-space:nowrap;">
                                    {{ $file->formatted_size }}
                                </td>

                                <td style="color:var(--gray-500);white-space:nowrap;">
                                    <div>{{ $file->created_at->format('d/m/Y') }}</div>
                                    <div style="font-size:0.75rem;">
                                        {{ $file->created_at->diffForHumans() }}
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ route('files.shared', $file->share_token) }}"
                                       class="fs-btn fs-btn-primary fs-btn-sm">
                                        ⬇ Télécharger
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    style="text-align:center;padding:3rem;color:var(--gray-500);">
                                    <div style="font-size:2.5rem;margin-bottom:0.75rem;">🌐</div>
                                    <div style="font-weight:500;margin-bottom:0.5rem;">
                                        Aucun fichier public disponible
                                    </div>
                                    <div style="font-size:0.875rem;">
                                        Soyez le premier à
                                        <a href="{{ route('files.index') }}"
                                           style="color:var(--violet-600);">
                                            partager un fichier →
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="padding:1rem 1.5rem;">
                {{ $files->links() }}
            </div>
        </div>

    </div>
</x-app-layout>