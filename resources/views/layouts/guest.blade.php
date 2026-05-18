<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FileShare') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="fs-auth-bg">
        <div class="fs-auth-card">
            <div class="fs-auth-logo">
                <img src="{{ asset('images/logo.svg') }}" alt="FileShare" style="height:44px;">
            </div>
            {{ $slot }}
        </div>
    </div>
</body>
</html>