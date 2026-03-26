<?php

namespace App\Http\Middleware;

use App\Models\File;
use Closure;
use Illuminate\Http\Request;

class CheckFileOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $file = $request->route('file');

        if ($file instanceof File) {
            if ($file->user_id !== auth()->id()) {
                abort(403, 'Accès non autorisé.');
            }
        }

        return $next($request);
    }
}