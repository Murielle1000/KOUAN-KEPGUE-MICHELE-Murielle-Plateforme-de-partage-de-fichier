{{-- Fichiers --}}
<div class="flex justify-between items-center mb-3">
    <h3 class="font-medium text-gray-700">Fichiers</h3>
    <a href="{{ route('files.create', ['folder_id' => $folder->id]) }}"
       class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
        + Uploader un fichier
    </a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Taille</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($folder->files as $file)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $file->original_name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $file->formatted_size }}</td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ $file->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('files.download', $file) }}"
                           class="text-blue-600 hover:underline text-xs">⬇ Télécharger</a>
                        <form action="{{ route('files.destroy', $file) }}" method="POST"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs">🗑 Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                        Aucun fichier dans ce dossier.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>