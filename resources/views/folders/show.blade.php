<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📁 {{ $folder->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Fil d'ariane --}}
            <nav class="mb-6 text-sm text-gray-500 flex gap-1 flex-wrap">
                <a href="{{ route('folders.index') }}" class="hover:underline">Mes dossiers</a>
                @foreach($breadcrumb as $crumb)
                    <span>/</span>
                    <a href="{{ route('folders.show', $crumb) }}"
                       class="hover:underline {{ $loop->last ? 'text-gray-900 font-medium' : '' }}">
                        {{ $crumb->name }}
                    </a>
                @endforeach
            </nav>

            {{-- Sous-dossiers --}}
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-medium text-gray-700">Sous-dossiers</h3>
                <a href="{{ route('folders.create', ['parent_id' => $folder->id]) }}"
                   class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    + Sous-dossier
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                @forelse($folder->children as $child)
                    <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                        <a href="{{ route('folders.show', $child) }}"
                           class="text-blue-600 hover:underline">
                            📁 {{ $child->name }}
                        </a>
                        <form action="{{ route('folders.destroy', $child) }}" method="POST"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-600 text-sm">🗑️</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm col-span-3">Aucun sous-dossier.</p>
                @endforelse
            </div>

            {{-- Fichiers (sera rempli à l'étape 5) --}}
            <h3 class="font-medium text-gray-700 mb-3">Fichiers</h3>
            <div class="bg-white p-6 rounded shadow text-gray-400 text-sm">
                Les fichiers apparaîtront ici (étape 5).
            </div>
        </div>
    </div>
</x-app-layout>