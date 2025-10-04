<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    @vite('resources/css/app.css') {{-- Si tu utilises Vite + Tailwind --}}
</head>

<body class="h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/bg-reset.jpg') }}');">
<div class="flex items-center justify-center h-full bg-black/50">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 w-full max-w-md">

        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800">
            🔐 Réinitialiser le mot de passe
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-300 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" autocomplete="off" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Champs "leurre" pour bloquer l'autofill -->
            <input type="text" name="fakeusernameremembered" style="display:none">
            <input type="password" name="fakepasswordremembered" style="display:none">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                <input type="email"
                       id="email"
                       name="email"
                       required
                       value="{{ old('email', $email ?? '') }}"
                       autocomplete="new-email"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Nouveau mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                <input type="password"
                       id="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-150 ease-in-out">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</div>
</body>
</html>
