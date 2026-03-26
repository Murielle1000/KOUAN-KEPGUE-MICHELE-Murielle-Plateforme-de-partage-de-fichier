<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mon espace fichiers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">

                <div class="bg-white rounded shadow p-5 flex items-center gap-4">
                    <div class="text-3xl">📁</div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ auth()->user()->folders()->count() }}
                        </p>
                        <p class="text-sm text-gray-500">Dossiers</p>
                    </div>
                </div>

                <div class="bg-white rounded shadow p-5 flex items-center gap-4">
                    <div class="text-3xl">📄</div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ auth()->user()->files()->count() }}
                        </p>
                        <p class="text-sm text-gray-500">Fichiers</p>
                    </div>
                </div>

                <div class="bg-white rounded shadow p-5 flex items-center gap-4">
                    <div class="text-3xl">🔗</div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ auth()->user()->files()->where('is_public', true)->count() }}
                        </p>
                        <p class="text-sm text-gray-500">Fichiers partagés</p>
                    </div>
                </div>

                <div class="bg-white rounded shadow p-5 flex items-center gap-4">
                    <div class="text-3xl">💾</div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format(auth()->user()->files()->sum('size') / 1048576, 1) }} MB
                        </p>
                        <p class="text-sm text-gray-500">Stockage utilisé</p>
                    </div>
                </div>

            </div>

            {{-- Actions rapides --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">

                <div class="bg-white rounded shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Actions rapides</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('files.create') }}"
                           class="flex items-center gap-3 bg-blue-600 text-white
                                  px-4 py-3 rounded hover:bg-blue-700 transition">
                            <span class="text-xl">⬆</span>
                            <span>Uploader un fichier</span>
                        </a>
                        <a href="{{ route('folders.create') }}"
                           class="flex items-center gap-3 bg-green-600 text-white
                                  px-4 py-3 rounded hover:bg-green-700 transition">
                            <span class="text-xl">📁</span>
                            <span>Créer un dossier</span>
                        </a>
                        <a href="{{ route('files.index') }}"
                           class="flex items-center gap-3 bg-gray-100 text-gray-700
                                  px-4 py-3 rounded hover:bg-gray-200 transition">
                            <span class="text-xl">🔍</span>
                            <span>Rechercher un fichier</span>
                        </a>
                    </div>
                </div>

                {{-- Fichiers récents --}}
                <div class="bg-white rounded shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Fichiers récents</h3>
                    @php
                        $recentFiles = auth()->user()->files()->latest()->take(5)->get();
                    @endphp
                    @forelse($recentFiles as $file)
                        <div class="flex justify-between items-center py-2
                                    border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">
                                    @if(str_contains($file->mime_type, 'image')) 🖼
                                    @elseif(str_contains($file->mime_type, 'pdf')) 📕
                                    @elseif(str_contains($file->mime_type, 'video')) 🎬
                                    @elseif(str_contains($file->mime_type, 'audio')) 🎵
                                    @elseif(str_contains($file->mime_type, 'zip')) 🗜
                                    @else 📄
                                    @endif
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-700 truncate max-w-48">
                                        {{ $file->original_name }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $file->formatted_size }} •
                                        {{ $file->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('files.download', $file) }}"
                               class="text-blue-500 hover:text-blue-700 text-xs">
                                ⬇
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">Aucun fichier récent.</p>
                    @endforelse
                </div>

            </div>

            {{-- Dossiers récents --}}
            <div class="bg-white rounded shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-700">Mes dossiers</h3>
                    <a href="{{ route('folders.index') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Voir tout →
                    </a>
                </div>
                @php
                    $recentFolders = auth()->user()->folders()
                        ->whereNull('parent_id')
                        ->latest()->take(6)->get();
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @forelse($recentFolders as $folder)
                        <a href="{{ route('folders.show', $folder) }}"
                           class="flex items-center gap-2 p-3 border rounded
                                  hover:bg-gray-50 transition">
                            <span class="text-xl">📁</span>
                            <div>
                                <p class="text-sm font-medium text-gray-700 truncate">
                                    {{ $folder->name }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $folder->files()->count() }} fichier(s)
                                </p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm col-span-3">
                            Aucun dossier créé.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>