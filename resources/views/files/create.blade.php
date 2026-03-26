<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload d'un fichier
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('files.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    @if($folder)
                        <input type="hidden" name="folder_id" value="{{ $folder->id }}">
                        <p class="mb-4 text-sm text-gray-500">
                            Dans le dossier : <strong>{{ $folder->name }}</strong>
                        </p>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Choisir un fichier
                        </label>
                        <input type="file" name="file"
                               class="w-full border rounded px-3 py-2 text-sm">
                        @error('file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">Taille max : 50 MB</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Uploader
                        </button>
                        <a href="{{ $folder ? route('folders.show', $folder) : route('files.index') }}"
                           class="px-4 py-2 rounded border hover:bg-gray-50">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>