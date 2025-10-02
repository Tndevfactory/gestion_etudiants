<div class="bg-gray-200 shadow-xl ">
    <div class="flex justify-between p-[1rem]">
        <div id='left' class='flex gap-2 justify-center items-center '>
            <img class='h-8' src="{{asset('images/logo.png')}}" alt="logo">
            <div>Gestion Etudiants</div>
        </div>


        <div class="flex items-center gap-2 ">
            @if(Auth::check())
                <img class='h-8 rounded-full ' src="{{ asset(Auth::user()->image) }}" alt=" user-image">
                <div class=" mr-2 text-sm"> {{ Auth::user()->name }}   </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-gray-800  hover:underline hover:text-gray-800 cursor-pointer  py-2
                    rounded-md text-sm font-medium">
                        Déconnexion
                    </button>
                </form>
            @else
                <div id='right'>
                    <a href="{{route('register')}}" class='text-sm
             hover:text-blue-800 transition '>Inscription</a>

                    <a href="{{route('login')}}" class='text-sm
             hover:text-blue-800 transition '> Connexion</a>
                </div>
            @endif
        </div>


    </div>
</div>
