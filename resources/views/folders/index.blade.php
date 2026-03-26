<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Mes dossiers</h1>
            <p>Organisez vos fichiers en dossiers</p>
        </div>
        <a href="{{ route('folders.create') }}" class="fs-btn" style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);color:white;">
            + Nouveau dossier
        </a>
    </x-slot>

    <div class="fs-main">
        @if(session('success'))
            <div class="fs-alert fs-alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="fs-card">
            <div class="fs-card-body">
                <div class="fs-folder-grid">
                    @forelse($folders as $folder)
                        <div style="position:relative;">
                            <a href="{{ route('folders.show', $folder) }}" class="fs-folder-item">
                                <div class="fs-folder-icon">📁</div>
                                <div style="flex:1;min-width:0;">
                                    <div class="fs-folder-name">{{ $folder->name }}</div>
                                    <div class="fs-folder-meta">{{ $folder->children->count() }} sous-dossier(s)</div>
                                </div>
                            </a>
                            <div style="display:flex;gap:0.4rem;margin-top:0.4rem;">
                                <a href="{{ route('folders.edit', $folder) }}" class="fs-btn fs-btn-ghost fs-btn-sm" style="flex:1;justify-content:center;">✏️ Renommer</a>
                                <form action="{{ route('folders.destroy', $folder) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="fs-btn fs-btn-danger fs-btn-sm">🗑</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--gray-500);">
                            <div style="font-size:3rem;margin-bottom:1rem;">📁</div>
                            <p style="font-size:0.95rem;">Aucun dossier. <a href="{{ route('folders.create') }}" style="color:var(--violet-600);">Créer le premier</a></p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>