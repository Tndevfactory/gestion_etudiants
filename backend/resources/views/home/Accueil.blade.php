@extends('layouts.HomeLayout')

@section('content')

<section id='hero'>
    <div class="relative min-h-[400px] flex items-center justify-center text-center p-10 overflow-hidden">

        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/bg.jpg') }}"
                 alt="Background"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>


        <div class="relative z-10  max-w-4xl">
            <h1 class="text-3xl font-bold mb-4 text-white">Bienvenue au Student Management System</h1>
            <p class="text-lg text-muted text-gray-100 font-light"> La solution moderne pour la gestion des etudiants.</p>
        </div>
    </div>
</section>

<section id='services' class="grid grid-cols-3 gap-4 p-10 place-items-center">
<h2 class="col-span-3 text-2xl font-bold mb-4 text-center">Nos Services</h2>
    <div id='card'>
        <div id='icon'>
            <img src="{{ asset('images/services/mentoring.png') }}" class="h-16">
        </div>
        <div id='title' class="leading-6 font-semibold my-1 text-xl">
            E-learning intégré
        </div>
        <div id='desc' class=" font-light text-gray-600 ml-1 ">
            Accès aux cours en ligne (vidéos, PDF, présentations). Classes virtuelles avec Zoom/Teams/BigBlueButton. QCM interactifs et quiz auto-corrigés.
        </div>
    </div>
    <div id='card'>
        <div id='icon'>
            <img src="{{ asset('images/services/leadership.png') }}" class="h-16">
        </div>
        <div id='title' class="leading-6 font-semibold my-1 text-xl">
            Accompagnement vers l’emploi
        </div>
        <div id='desc' class=" font-light text-gray-600 ml-1 ">
           Gestion de stages et opportunités professionnelles. Suivi de progression (badges, niveaux, gamification).
        </div>
    </div>
    <div id='card'>
        <div id='icon'>
            <img src="{{ asset('images/services/management.png') }}" class="h-16">
        </div>
        <div id='title' class="leading-6 font-semibold my-1 text-xl">
            Analyse de parcours professionnel
        </div>
        <div id='desc' class=" font-light text-gray-600 ml-1 ">
            Historique complet des résultats et compétences acquises. Gestion de stages et opportunités professionnelles.
        </div>
    </div>

</section>

<section id='news' class="grid grid-cols-3 gap-4 p-10 place-items-center">
<h2 class="col-span-3 text-2xl font-bold mb-4 text-center">Nouveautés</h2>
    <div id='card'>
        <div id='icon'>
            <img src="{{ asset('images/services/helping-hand.png') }}" class="h-16">
        </div>
        <div id='title' class="leading-6 font-semibold my-1 text-xl">
            Académiques
        </div>
        <div id='desc' class=" font-light text-gray-600 ml-1 ">
           Annonce de nouveaux cours disponibles sur la plateforme e-learning. Nouveaux modules de formation (par ex. Soft Skills, Langues, IA, etc.).
        </div>
    </div>
    <div id='card'>
        <div id='icon'>
            <img src="{{ asset('images/services/communication.png') }}" class="h-16">
        </div>
        <div id='title' class="leading-6 font-semibold my-1 text-xl">
            Événements
        </div>
        <div id='desc' class=" font-light text-gray-600 ml-1 ">
           Webinaires ou conférences à venir.Concours, hackathons ou compétitions inter-étudiants. Activités culturelles, clubs ou événements sportifs.
        </div>
    </div>
    <div id='card'>
        <div id='icon'>
            <img src="{{ asset('images/services/coaching.png') }}" class="h-16">
        </div>
        <div id='title' class="leading-6 font-semibold my-1 text-xl">
            Fonctionnalités de la plateforme
        </div>
        <div id='desc' class=" font-light text-gray-600 ml-1 ">
            Nouvelles fonctionnalités (ex : suivi de progression amélioré, chatbot d’aide). Amélioration du tableau de bord étudiant
        </div>
    </div>

</section>

@endsection
