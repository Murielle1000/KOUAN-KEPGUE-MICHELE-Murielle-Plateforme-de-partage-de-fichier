<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>📋 Historique</h1>
            <p>{{ $file->original_name }}</p>
        </div>
        <a href="{{ route('files.index') }}" class="fs-btn"
           style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);color:white;">
            ← Retour
        </a>
    </x-slot>

    <div class="fs-main">

        {{-- Stats résumé --}}
        <div class="fs-stats" style="margin-bottom:1.25rem;">
            <div class="fs-stat">
                <div class="fs-stat-icon">📥</div>
                <div>
                    <div class="fs-stat-value">{{ $logs->total() }}</div>
                    <div class="fs-stat-label">Total téléchargements</div>
                </div>
            </div>
            <div class="fs-stat">
                <div class="fs-stat-icon">🔗</div>
                <div>
                    <div class="fs-stat-value">
                        {{ $logs->where('is_public_access', true)->count() }}
                    </div>
                    <div class="fs-stat-label">Via lien public</div>
                </div>
            </div>
            <div class="fs-stat">
                <div class="fs-stat-icon">👤</div>
                <div>
                    <div class="fs-stat-value">
                        {{ $logs->where('is_public_access', false)->count() }}
                    </div>
                    <div class="fs-stat-label">Utilisateurs connectés</div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="fs-card">
            <div class="fs-card-header">
                <h3>Détail des accès</h3>
                <span class="fs-badge fs-badge-info">
                    {{ $logs->total() }} entrée(s)
                </span>
            </div>
            <div class="fs-table-wrapper">
                <table class="fs-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Adresse IP</th>
                            <th>Type d'accès</th>
                            <th>Navigateur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td style="white-space:nowrap;">
                                    <span style="font-weight:500;">
                                        {{ $log->created_at->format('d/m/Y') }}
                                    </span>
                                    <div style="font-size:0.75rem;color:var(--gray-500);">
                                        {{ $log->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td>
                                    @if($log->user)
                                        <div style="display:flex;align-items:center;gap:0.5rem;">
                                            <div style="width:28px;height:28px;border-radius:50%;
                                                        background:var(--violet-500);color:white;
                                                        display:flex;align-items:center;
                                                        justify-content:center;font-size:0.75rem;
                                                        font-weight:600;flex-shrink:0;">
                                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $log->user->name }}</span>
                                        </div>
                                    @else
                                        <span style="color:var(--gray-500);">Anonyme</span>
                                    @endif
                                </td>
                                <td style="color:var(--gray-500);font-family:monospace;
                                           font-size:0.82rem;white-space:nowrap;">
                                    {{ $log->ip_address }}
                                </td>
                                <td style="white-space:nowrap;">
                                    @if($log->is_public_access)
                                        <span class="fs-badge"
                                              style="background:#fff3e0;color:#e65100;">
                                            🔗 Lien public
                                        </span>
                                    @else
                                        <span class="fs-badge fs-badge-info">
                                            👤 Connecté
                                        </span>
                                    @endif
                                </td>
                                <td style="color:var(--gray-500);font-size:0.8rem;
                                           max-width:180px;overflow:hidden;
                                           text-overflow:ellipsis;white-space:nowrap;">
                                    {{ Str::limit($log->user_agent, 45) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    style="text-align:center;padding:3rem;color:var(--gray-500);">
                                    <div style="font-size:2rem;margin-bottom:0.5rem;">📭</div>
                                    Aucun téléchargement enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="padding:1rem 1.5rem;">
                {{ $logs->links() }}
            </div>
        </div>

    </div>
</x-app-layout>