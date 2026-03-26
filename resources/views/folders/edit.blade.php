<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Renommer le dossier</h1>
            <p>Modifier le nom de "{{ $folder->name }}"</p>
        </div>
    </x-slot>

    <div class="fs-main">
        <div style="max-width:520px;margin:0 auto;">
            <div class="fs-card">
                <div class="fs-card-header">
                    <h3>✏️ Nouveau nom</h3>
                </div>
                <div class="fs-card-body">
                    <form action="{{ route('folders.update', $folder) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="fs-form-group">
                            <label class="fs-label">Nom du dossier</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $folder->name) }}"
                                   class="fs-input" autofocus required>
                            @error('name')
                                <p class="fs-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                            <button type="submit" class="fs-btn fs-btn-primary" style="flex:1;justify-content:center;">
                                ✅ Enregistrer
                            </button>
                            <a href="{{ route('folders.index') }}" class="fs-btn fs-btn-ghost">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>