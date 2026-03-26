<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mes fichiers
            </h2>
            <a href="{{ route('files.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Uploader
            </a>
        </div>
    </x-slot>

    {{-- Barre de recherche et filtres --}}
    <div class="mb-4 bg-white p-4 rounded shadow">
        <form action="{{ route('files.index') }}" method="GET"
            class="flex gap-3 flex-wrap items-end">

            <div class="flex-1 min-w-48">
                <label class="block text-xs text-gray-500 mb-1">Rechercher par nom</label>
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="nom du fichier..."
                    class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div class="min-w-40">
                <label class="block text-xs text-gray-500 mb-1">Filtrer par type</label>
                <select name="type" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">Tous les types</option>
                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>
                        Images
                    </option>
                    <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>
                        PDF
                    </option>
                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>
                        Vidéos
                    </option>
                    <option value="audio" {{ request('type') == 'audio' ? 'selected' : '' }}>
                        Audio
                    </option>
                    <option value="zip" {{ request('type') == 'zip' ? 'selected' : '' }}>
                        Archives
                    </option>
                    <option value="text" {{ request('type') == 'text' ? 'selected' : '' }}>
                        Texte
                    </option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                    🔍 Rechercher
                </button>
                @if(request('search') || request('type'))
                    <a href="{{ route('files.index') }}"
                    class="px-4 py-2 rounded border text-sm hover:bg-gray-50">
                        ✕ Effacer
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Affichage du lien de partage généré --}}
            @if(session('share_url'))
                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded">
                    <p class="text-sm font-medium text-blue-800 mb-2">
                        🔗 Lien de partage généré :
                    </p>
                    <div class="flex gap-2 items-center">
                        <input type="text"
                               value="{{ session('share_url') }}"
                               class="flex-1 border rounded px-3 py-1 text-sm bg-white"
                               readonly
                               onclick="this.select()">
                        <button onclick="navigator.clipboard.writeText('{{ session('share_url') }}')"
                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            Copier
                        </button>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Nom</th>
                            <th class="px-4 py-3 text-left">Type</th>
                            <th class="px-4 py-3 text-left">Taille</th>
                            <th class="px-4 py-3 text-left">Dossier</th>
                            <th class="px-4 py-3 text-left">Partage</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($files as $file)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">
                                    {{ $file->original_name }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $file->mime_type }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $file->formatted_size }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $file->folder?->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($file->is_public)
                                        <span class="text-green-600 text-xs font-medium">
                                            ✅ Public
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            🔒 Privé
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2 flex-wrap">
                                        {{-- Télécharger --}}
                                        <a href="{{ route('files.download', $file) }}"
                                           class="text-blue-600 hover:underline text-xs">
                                            ⬇ Télécharger
                                        </a>

                                        <a href="{{ route('files.logs', $file) }}"
                                            class="text-purple-600 hover:underline text-xs">
                                            📋 Historique
                                        </a>

                                        {{-- Partager / Révoquer --}}
                                        @if($file->is_public)
                                            <form action="{{ route('files.revoke-share', $file) }}"
                                                  method="POST">
                                                @csrf @method('DELETE')
                                                <button class="text-orange-500 hover:underline text-xs">
                                                    🔒 Révoquer
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('files.share', $file) }}"
                                                  method="POST">
                                                @csrf
                                                <button class="text-green-600 hover:underline text-xs">
                                                    🔗 Partager
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Supprimer --}}
                                        <form action="{{ route('files.destroy', $file) }}"
                                              method="POST"
                                              onsubmit="return confirm('Supprimer ?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:underline text-xs">
                                                🗑 Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                    Aucun fichier uploadé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $files->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>