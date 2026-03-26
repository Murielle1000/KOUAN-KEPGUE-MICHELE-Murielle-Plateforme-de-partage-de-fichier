<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Nouveau dossier</h1>
            <p>Créez un dossier pour organiser vos fichiers</p>
        </div>
    </x-slot>

    <div class="fs-main">
        <div style="max-width:520px;margin:0 auto;">
            <div class="fs-card">
                <div class="fs-card-header">
                    <h3>📁 Informations du dossier</h3>
                </div>
                <div class="fs-card-body">

                    @if($parent)
                        <div class="fs-alert fs-alert-info" style="margin-bottom:1.25rem;">
                            📁 Sous-dossier de : <strong>{{ $parent->name }}</strong>
                        </div>
                    @endif

                    <form action="{{ route('folders.store') }}" method="POST">
                        @csrf
                        @if($parent)
                            <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                        @endif

                        <div class="fs-form-group">
                            <label class="fs-label">Nom du dossier</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="fs-input" placeholder="Ex: Projets 2024"
                                   autofocus required>
                            @error('name')
                                <p class="fs-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                            <button type="submit" class="fs-btn fs-btn-primary" style="flex:1;justify-content:center;">
                                📁 Créer le dossier
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