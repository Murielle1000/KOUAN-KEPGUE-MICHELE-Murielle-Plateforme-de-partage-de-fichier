<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouveau dossier
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('folders.store') }}" method="POST">
                    @csrf

                    @if($parent)
                        <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                        <p class="mb-4 text-sm text-gray-500">
                            Sous-dossier de : <strong>{{ $parent->name }}</strong>
                        </p>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Nom du dossier
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 w-full border rounded px-3 py-2"
                               placeholder="Mon dossier">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Créer
                        </button>
                        <a href="{{ route('folders.index') }}"
                           class="px-4 py-2 rounded border hover:bg-gray-50">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>