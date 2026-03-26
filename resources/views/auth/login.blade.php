<x-guest-layout>
    <h2 class="fs-auth-title">Connexion</h2>
    <p class="fs-auth-subtitle">Accédez à votre espace FileShare</p>

    @if ($errors->any())
        <div class="fs-alert fs-alert-success" style="background:#fde8e8;color:#c0392b;border-color:#fcc;">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="fs-form-group">
            <label class="fs-label">Adresse email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="fs-input" placeholder="vous@exemple.com" required autofocus>
            @error('email') <p class="fs-error">{{ $message }}</p> @enderror
        </div>
        <div class="fs-form-group">
            <label class="fs-label">Mot de passe</label>
            <input type="password" name="password"
                   class="fs-input" placeholder="••••••••" required>
            @error('password') <p class="fs-error">{{ $message }}</p> @enderror
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.85rem;color:var(--gray-600);cursor:pointer;">
                <input type="checkbox" name="remember"> Se souvenir de moi
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:0.85rem;color:var(--violet-600);text-decoration:none;">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>
        <button type="submit" class="fs-btn fs-btn-primary" style="width:100%;justify-content:center;padding:0.85rem;">
            Se connecter
        </button>
        @if (Route::has('register'))
            <p style="text-align:center;margin-top:1.25rem;font-size:0.875rem;color:var(--gray-500);">
                Pas encore de compte ?
                <a href="{{ route('register') }}" style="color:var(--violet-600);font-weight:500;text-decoration:none;">S'inscrire</a>
            </p>
        @endif
    </form>
</x-guest-layout>