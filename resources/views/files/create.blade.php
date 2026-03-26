<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Uploader un fichier</h1>
            <p>Ajoutez un fichier à votre espace</p>
        </div>
    </x-slot>

    <div class="fs-main">
        <div style="max-width:560px;margin:0 auto;">
            <div class="fs-card">
                <div class="fs-card-header">
                    <h3>⬆ Nouveau fichier</h3>
                </div>
                <div class="fs-card-body">

                    @if($folder)
                        <div class="fs-alert fs-alert-info" style="margin-bottom:1.25rem;">
                            📁 Destination : <strong>{{ $folder->name }}</strong>
                        </div>
                    @endif

                    <form action="{{ route('files.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @if($folder)
                            <input type="hidden" name="folder_id" value="{{ $folder->id }}">
                        @endif

                        {{-- Zone de drop --}}
                        <div class="fs-form-group">
                            <label class="fs-label">Fichier à uploader</label>
                            <label for="file-input" style="
                                display:flex;
                                flex-direction:column;
                                align-items:center;
                                justify-content:center;
                                gap:0.75rem;
                                padding:2.5rem;
                                border:2px dashed var(--violet-200);
                                border-radius:var(--radius-md);
                                background:var(--violet-50);
                                cursor:pointer;
                                transition:all 0.2s;
                                text-align:center;
                            "
                            onmouseover="this.style.borderColor='var(--violet-500)';this.style.background='var(--violet-100)'"
                            onmouseout="this.style.borderColor='var(--violet-200)';this.style.background='var(--violet-50)'">
                                <div style="font-size:2.5rem;">📂</div>
                                <div>
                                    <div style="font-family:'Outfit',sans-serif;font-weight:600;color:var(--violet-600);font-size:0.95rem;">
                                        Cliquez pour choisir un fichier
                                    </div>
                                    <div style="font-size:0.8rem;color:var(--gray-500);margin-top:0.25rem;">
                                        ou glissez-déposez ici
                                    </div>
                                </div>
                                <div id="file-name" style="font-size:0.8rem;color:var(--gray-500);">
                                    Taille max : 50 MB
                                </div>
                            </label>
                            <input type="file" name="file" id="file-input"
                                   style="display:none;" required
                                   onchange="document.getElementById('file-name').textContent = this.files[0] ? this.files[0].name : 'Aucun fichier'">
                            @error('file')
                                <p class="fs-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                            <button type="submit" class="fs-btn fs-btn-primary" style="flex:1;justify-content:center;">
                                ⬆ Uploader
                            </button>
                            <a href="{{ $folder ? route('folders.show', $folder) : route('files.index') }}"
                               class="fs-btn fs-btn-ghost">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Infos --}}
            <div class="fs-card" style="margin-top:1rem;">
                <div class="fs-card-body" style="display:flex;flex-direction:column;gap:0.5rem;">
                    <div style="font-family:'Outfit',sans-serif;font-size:0.8rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
                        Types acceptés
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                        @foreach(['🖼 Images', '📕 PDF', '📝 Word/Excel', '🎬 Vidéos', '🎵 Audio', '🗜 Archives'] as $type)
                            <span class="fs-badge fs-badge-info">{{ $type }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>