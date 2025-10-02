<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/login.jpg') }}');">

<!-- Overlay sombre pour améliorer le contraste -->
<div class="absolute inset-0 bg-black/50 bg-opacity-50"></div>

<!-- Formulaire avec effet glassmorphisme -->
<div class="relative z-10 w-full max-w-md bg-white bg-opacity-90 backdrop-blur-md shadow-2xl rounded-2xl p-8 border border-white border-opacity-20">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Créer un compte</h2>
    <div class=" flex justify-center mb-6 "><img  class='h-12' src="{{asset('images/logo.png')}}" alt="logo"></div>

    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-600 border border-red-300">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:outline-none transition duration-200 bg-white bg-opacity-50"
                   required autofocus>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:outline-none transition duration-200 bg-white bg-opacity-50"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
            <input type="password" name="password"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:outline-none transition duration-200 bg-white bg-opacity-50"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer mot de passe</label>
            <input type="password" name="password_confirmation"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:outline-none transition duration-200 bg-white bg-opacity-50"
                   required>
        </div>


        <button type="submit"
                class="cursor-pointer  w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg">
            S'inscrire
        </button>
    </form>

    <p class="mt-6 text-sm text-gray-600 text-center">
        Déjà un compte ?
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 hover:underline font-medium transition duration-200">Se connecter</a>
    </p>
</div>

</body>
</html>
