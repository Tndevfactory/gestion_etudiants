<div class="bg-gray-200 shadow-xl ">
    <div class="flex justify-between p-[1rem]">
        <div id='left' class='flex gap-2 '>
           <div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bolt-icon lucide-bolt"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><circle cx="12" cy="12" r="4"/></svg></div>
           <div>Gestion Etudiants</div>
        </div>

        <div id='right'>

            <a href="{{route('register')}}" class='text-sm
             hover:text-blue-800 transition '>Inscription</a>

            <a href="{{route('login')}}" class='text-sm
             hover:text-blue-800 transition '> Connexion</a>
        </div>
    </div>
</div>
