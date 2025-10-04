<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat bg-fixed"
      style="background-image: url('{{ asset('images/login.jpg') }}');">

<!-- Overlay sombre pour améliorer le contraste -->
<div class="absolute inset-0 bg-black/50 bg-opacity-50"></div>

<!-- Formulaire avec effet glassmorphisme -->
<div class="relative z-10 w-full max-w-md bg-white bg-opacity-90 backdrop-blur-md shadow-2xl rounded-2xl p-8 border border-white border-opacity-20">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2 ">Se connecter</h2>
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

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:outline-none transition duration-200 bg-white bg-opacity-50">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
            <input type="password" name="password"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:outline-none transition duration-200 bg-white bg-opacity-50">

            <a href="{{route('password.request')}}" class=" hover:underline text-blue-600 text-sm">Oubli de mot de passe</a>
        </div>


        <button type="submit"
                class=" cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg">
            Connexion
        </button>
        <a href="{{ route('google.login') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full text-center hover:bg-blue-600 transition duration-200  transform hover:scale-105 flex items-center justify-center gap-2">
            Se connecter avec Google
        </a>
    </form>

    <p class="mt-6 text-sm text-gray-600 text-center">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 hover:underline font-medium transition duration-200">Créer un compte</a>
    </p>
</div>

</body>
</html>
