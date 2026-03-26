<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FileShare') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app-custom.css') }}">
</head>
<body>

    {{-- Navigation --}}
    <nav class="fs-nav">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="FileShare" style="height:36px;">
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Accueil
                </a>
                <a href="{{ route('folders.index') }}"
                   class="nav-link {{ request()->routeIs('folders.*') ? 'active' : '' }}">
                    Dossiers
                </a>
                <a href="{{ route('files.index') }}"
                   class="nav-link {{ request()->routeIs('files.*') ? 'active' : '' }}">
                    Fichiers
                </a>
            </div>
        </div>

        <div class="nav-user">
            <div class="dropdown">
                <div class="nav-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="dropdown-menu">
                    <div style="padding:0.75rem 1rem 0.5rem;">
                        <div style="font-weight:600;font-size:0.875rem;color:var(--gray-900)">
                            {{ auth()->user()->name }}
                        </div>
                        <div style="font-size:0.75rem;color:var(--gray-500)">
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        ⚙️ Mon profil
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger"
                                style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
                            🚪 Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Header de page --}}
    @isset($header)
        <div class="fs-header">
            <div class="fs-header-inner">
                {{ $header }}
            </div>
        </div>
    @endisset

    {{-- Contenu --}}
    <main>
        {{ $slot }}
    </main>

</body>
</html>