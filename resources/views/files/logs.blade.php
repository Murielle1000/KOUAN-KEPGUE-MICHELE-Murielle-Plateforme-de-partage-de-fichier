<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Historique — {{ $file->original_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-between items-center">
                <p class="text-sm text-gray-500">
                    {{ $logs->total() }} téléchargement(s) au total
                </p>
                <a href="{{ route('files.index') }}"
                   class="text-sm text-blue-600 hover:underline">
                    ← Retour aux fichiers
                </a>
            </div>

            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Utilisateur</th>
                            <th class="px-4 py-3 text-left">IP</th>
                            <th class="px-4 py-3 text-left">Type d'accès</th>
                            <th class="px-4 py-3 text-left">Navigateur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $log->user?->name ?? 'Anonyme' }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $log->ip_address }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($log->is_public_access)
                                        <span class="bg-orange-100 text-orange-700
                                                     px-2 py-1 rounded text-xs">
                                            Lien public
                                        </span>
                                    @else
                                        <span class="bg-blue-100 text-blue-700
                                                     px-2 py-1 rounded text-xs">
                                            Connecté
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-400 text-xs truncate max-w-xs">
                                    {{ Str::limit($log->user_agent, 60) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-4 py-8 text-center text-gray-400">
                                    Aucun téléchargement enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>