<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Livewire</title>

    <!-- Tailwind CSS -->
    <link href="{{ asset('dist/output.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col items-center justify-center">

    <h1 class="text-3xl font-bold mb-6 text-blue-600">Page de test avec Livewire</h1>

    <!-- Intégration du composant Dashboard -->
    <livewire:dashboard />

    @livewireScripts
</body>
</html>
