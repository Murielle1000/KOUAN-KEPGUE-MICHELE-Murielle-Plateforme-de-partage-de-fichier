<x-guest-layout>
    <h2 class="fs-auth-title">Créer un compte</h2>
    <p class="fs-auth-subtitle">Rejoignez FileShare gratuitement</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="fs-form-group">
            <label class="fs-label">Nom complet</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="fs-input" placeholder="Votre nom" required autofocus>
            @error('name') <p class="fs-error">{{ $message }}</p> @enderror
        </div>
        <div class="fs-form-group">
            <label class="fs-label">Adresse email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="fs-input" placeholder="vous@exemple.com" required>
            @error('email') <p class="fs-error">{{ $message }}</p> @enderror
        </div>
        <div class="fs-form-group">
            <label class="fs-label">Mot de passe</label>
            <input type="password" name="password"
                   class="fs-input" placeholder="Min. 8 caractères" required>
            @error('password') <p class="fs-error">{{ $message }}</p> @enderror
        </div>
        <div class="fs-form-group">
            <label class="fs-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation"
                   class="fs-input" placeholder="••••••••" required>
        </div>
        <button type="submit" class="fs-btn fs-btn-primary" style="width:100%;justify-content:center;padding:0.85rem;">
            Créer mon compte
        </button>
        <p style="text-align:center;margin-top:1.25rem;font-size:0.875rem;color:var(--gray-500);">
            Déjà un compte ?
            <a href="{{ route('login') }}" style="color:var(--violet-600);font-weight:500;text-decoration:none;">Se connecter</a>
        </p>
    </form>
</x-guest-layout>