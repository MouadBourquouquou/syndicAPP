{{-- resources/views/auth/reset-password.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialiser le mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Optionnel : lien Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-xl font-bold mb-6 text-center">Réinitialiser le mot de passe</h1>

        @if (session('status'))
            <div class="mb-4 text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label class="block text-sm font-medium">Nouveau mot de passe</label>
                <input type="password" name="password" required
                       class="w-full border rounded px-3 py-2 mt-1">
                @error('password')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Confirmation</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border rounded px-3 py-2 mt-1">
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                Réinitialiser
            </button>
        </form>
    </div>
</body>
</html>
