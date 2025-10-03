@extends('layouts.AdminLayout')

@section('content')


        <div x-data="{ openCreate:false, openEdit:false, openDelete:false, selectedUser:null }" class="p-6">

            <h1 class="text-2xl font-bold mb-4">Gestion des Enseignants</h1>

            <div class="flex justify-between items-center mb-4">
                <!-- 🔍 Recherche -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex">
                    <input type="text" name="search" placeholder="Rechercher..." value="{{ $search }}"
                           class="border p-2 rounded-l w-64">
                    <button class="bg-blue-500 text-white px-4 rounded-r">Rechercher</button>
                </form>

                <!-- ➕ Bouton création -->

                <button @click="openCreate=true"
                        class="bg-green-500 text-white px-4 py-2 mb-4 rounded">Ajouter un utilisateur</button>
            </div>


            <!-- 📋 Tableau -->
            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Image</th>
                        <th class="p-2 border">Nom</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">Rôle</th>
                        <th class="p-2 border">Téléphone</th>
                        <th class="p-2 border">Spécialité</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($users as $user)
                        <tr>
                            <td class="border p-2 text-center">
                                @if($user->image)
                                    <img src="{{ asset($user->image) }}" class="w-12 h-12 rounded-full mx-auto">
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="border p-2">{{ $user->name }}</td>
                            <td class="border p-2">{{ $user->email }}</td>
                            <td class="border p-2">{{ $user->role?->name }}</td>
                            <td class="border p-2">{{ $user->teacher?->phone }}</td>
                            <td class="border p-2">{{ $user->teacher?->specialty }}</td>
                            <td class="border p-2 flex gap-2 justify-center">
                                <button @click="openEdit=true; selectedUser={{ $user->toJson() }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Modifier</button>
                                <button @click="openDelete=true; selectedUser={{ $user->id }}" class="bg-red-500 text-white px-2 py-1 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 📄 Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>

            <!-- ➕ Modal Création -->
            <div x-show="openCreate" x-cloak class="fixed inset-0 bg-black/50 bg-opacity-50 flex justify-end">
                <div class="bg-white w-1/3 p-6 shadow-lg">
                    <h2 class="text-xl font-bold mb-4">Créer un utilisateur</h2>
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="name" placeholder="Nom" class="w-full border p-2 mb-2">
                        <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-2">
                        <input type="password" name="password" placeholder="Mot de passe" class="w-full border p-2 mb-2">
                        <input type="file" name="image" class="w-full border p-2 mb-2">
                        <input type="text" name="teacher[phone]" placeholder="Téléphone" class="w-full border p-2 mb-2">
                        <input type="text" name="teacher[specialty]" placeholder="Spécialité" class="w-full border p-2 mb-2">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Créer</button>
                        <button type="button" @click="openCreate=false" class="ml-2 bg-gray-400 text-white px-4 py-2 rounded">Annuler</button>
                    </form>
                </div>
            </div>

            <!-- ✏️ Modal Modification -->
            <div x-show="openEdit" x-cloak class="fixed inset-0 bg-black/50 bg-opacity-50 flex justify-end">
                <div class="bg-white w-1/3 p-6 shadow-lg" x-show="selectedUser">
                    <h2 class="text-xl font-bold mb-4">Modifier l'utilisateur</h2>
                    <form :action="'/admin/users/' + selectedUser.id" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <input type="text" name="name" :value="selectedUser.name"   class="w-full border p-2 mb-2">
                        <input type="email" name="email" :value="selectedUser.email" class="w-full border p-2 mb-2">
                        <input type="password" name="password" placeholder="Nouveau mot de passe" class="w-full border p-2 mb-2">
                        <input type="file" name="image" class="w-full border p-2 mb-2">
                        <input type="text" name="teacher[phone]" :value="selectedUser.teacher?.phone" class="w-full border p-2 mb-2">
                        <input type="text" name="teacher[specialty]" :value="selectedUser.teacher?.specialty" class="w-full border p-2 mb-2">
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Mettre à jour</button>
                        <button type="button" @click="openEdit=false" class="ml-2 bg-gray-400 text-white px-4 py-2 rounded">Annuler</button>
                    </form>
                </div>
            </div>

            <!-- ❌ Modal Suppression -->
            <div x-show="openDelete"  x-cloak class="fixed inset-0 bg-black/50 bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded shadow-lg">
                    <h2 class="text-lg mb-4">Confirmer la suppression ?</h2>
                    <form :action="'/admin/users/' + selectedUser" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Supprimer</button>
                        <button type="button" @click="openDelete=false" class="ml-2 bg-gray-400 text-white px-4 py-2 rounded">Annuler</button>
                    </form>
                </div>
            </div>

        </div>



@endsection
