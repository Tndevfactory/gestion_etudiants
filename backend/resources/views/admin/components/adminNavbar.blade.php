<nav
    class="relative bg-gray-100 border-b text-gray-800  h-12  px-6 flex justify-between items-center shadow-md">
    <div class="flex justify-between items-center w-full">
        <div class="flex items-center gap-2 ">
            @if(Auth::check())
                <img  class='h-8 rounded-full ' src="{{ asset(Auth::user()->image) }}" alt=" user-image">
                <div class=" mr-4">Bonjour, {{ Auth::user()->name }} ,  {{ Auth::user()->role->name }}  </div>
            @endif
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="text-gray-800  hover:underline hover:text-gray-800 cursor-pointer px-3 py-2
                    rounded-md text-sm font-medium">
                Déconnexion
            </button>
        </form>
    </div>

</nav>




