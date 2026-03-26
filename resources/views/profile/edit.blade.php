<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Mon profil</h1>
            <p>Gérez vos informations personnelles</p>
        </div>
    </x-slot>

    <div class="fs-main">
        <div style="max-width:640px;margin:0 auto;display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Infos profil --}}
            <div class="fs-card">
                <div class="fs-card-header">
                    <h3>👤 Informations du compte</h3>
                </div>
                <div class="fs-card-body">
                    <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1.75rem;padding:1.25rem;background:var(--violet-50);border-radius:var(--radius-md);">
                        <div style="width:60px;height:60px;border-radius:50%;background:var(--violet-500);color:white;display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-size:1.5rem;font-weight:700;flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-family:'Outfit',sans-serif;font-weight:600;font-size:1.1rem;color:var(--gray-900);">
                                {{ auth()->user()->name }}
                            </div>
                            <div style="color:var(--gray-500);font-size:0.875rem;">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf @method('patch')

                        <div class="fs-form-group">
                            <label class="fs-label">Nom complet</label>
                            <input type="text" name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   class="fs-input" required>
                            @error('name') <p class="fs-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="fs-form-group">
                            <label class="fs-label">Adresse email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   class="fs-input" required>
                            @error('email') <p class="fs-error">{{ $message }}</p> @enderror
                        </div>

                        @if(session('status') === 'profile-updated')
                            <div class="fs-alert fs-alert-success">✅ Profil mis à jour.</div>
                        @endif

                        <button type="submit" class="fs-btn fs-btn-primary">
                            💾 Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>

            {{-- Mot de passe --}}
            <div class="fs-card">
                <div class="fs-card-header">
                    <h3>🔐 Changer le mot de passe</h3>
                </div>
                <div class="fs-card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf @method('put')

                        <div class="fs-form-group">
                            <label class="fs-label">Mot de passe actuel</label>
                            <input type="password" name="current_password"
                                   class="fs-input" placeholder="••••••••">
                            @error('current_password', 'updatePassword')
                                <p class="fs-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="fs-form-group">
                            <label class="fs-label">Nouveau mot de passe</label>
                            <input type="password" name="password"
                                   class="fs-input" placeholder="Min. 8 caractères">
                            @error('password', 'updatePassword')
                                <p class="fs-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="fs-form-group">
                            <label class="fs-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation"
                                   class="fs-input" placeholder="••••••••">
                        </div>

                        @if(session('status') === 'password-updated')
                            <div class="fs-alert fs-alert-success">✅ Mot de passe mis à jour.</div>
                        @endif

                        <button type="submit" class="fs-btn fs-btn-primary">
                            🔐 Mettre à jour
                        </button>
                    </form>
                </div>
            </div>

            {{-- Supprimer le compte --}}
            <div class="fs-card" style="border-color:#ffd0cc;">
                <div class="fs-card-header" style="background:#fff8f8;">
                    <h3 style="color:#c0392b;">⚠️ Zone dangereuse</h3>
                </div>
                <div class="fs-card-body">
                    <p style="font-size:0.875rem;color:var(--gray-500);margin-bottom:1.25rem;">
                        La suppression de votre compte est irréversible. Toutes vos données seront définitivement effacées.
                    </p>
                    <form method="POST" action="{{ route('profile.destroy') }}"
                          onsubmit="return confirm('Êtes-vous sûr ? Cette action est irréversible.')">
                        @csrf @method('delete')

                        <div class="fs-form-group">
                            <label class="fs-label">Confirmez avec votre mot de passe</label>
                            <input type="password" name="password"
                                   class="fs-input" placeholder="Votre mot de passe actuel"
                                   style="border-color:#ffd0cc;">
                            @error('password', 'userDeletion')
                                <p class="fs-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="fs-btn"
                                style="background:#c0392b;color:white;border:none;">
                            🗑 Supprimer définitivement mon compte
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>