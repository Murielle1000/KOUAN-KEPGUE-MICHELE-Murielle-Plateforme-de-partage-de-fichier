<x-app-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-red-500">403</h1>
            <p class="text-xl text-gray-600 mt-4">Accès non autorisé</p>
            <p class="text-gray-400 mt-2">
                Vous n'avez pas la permission d'accéder à cette ressource.
            </p>
            <a href="{{ route('dashboard') }}"
               class="mt-6 inline-block bg-blue-600 text-white
                      px-6 py-3 rounded hover:bg-blue-700">
                Retour au dashboard
            </a>
        </div>
    </div>
</x-app-layout>