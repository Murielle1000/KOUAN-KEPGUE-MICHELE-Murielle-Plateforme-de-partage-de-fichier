<x-app-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-gray-400">404</h1>
            <p class="text-xl text-gray-600 mt-4">Page introuvable</p>
            <p class="text-gray-400 mt-2">
                La page ou le fichier que vous cherchez n'existe pas.
            </p>
            <a href="{{ route('dashboard') }}"
               class="mt-6 inline-block bg-blue-600 text-white
                      px-6 py-3 rounded hover:bg-blue-700">
                Retour au dashboard
            </a>
        </div>
    </div>
</x-app-layout>