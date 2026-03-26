<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mes dossiers
            </h2>
            <a href="{{ route('folders.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nouveau dossier
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @forelse($folders as $folder)
                    <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                        <a href="{{ route('folders.show', $folder) }}"
                           class="text-blue-600 font-medium hover:underline">
                            📁 {{ $folder->name }}
                        </a>
                        <div class="flex gap-2">
                            <a href="{{ route('folders.edit', $folder) }}"
                               class="text-sm text-gray-500 hover:text-gray-700">✏️</a>
                            <form action="{{ route('folders.destroy', $folder) }}" method="POST"
                                  onsubmit="return confirm('Supprimer ce dossier ?')">
                                @csrf @method('DELETE')
                                <button class="text-sm text-red-500 hover:text-red-700">🗑️</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3">Aucun dossier. Créez-en un !</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>