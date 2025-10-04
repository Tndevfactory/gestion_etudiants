@extends('layouts.AdminLayout')
@section('content')

    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl uppercase font-medium mb-2">Gestion des Roles datatables</h2>
            <button id="openCreateModalButton" class="px-3 py-1 text-sm font-medium text-white
                            bg-blue-600 rounded hover:bg-blue-700 focus:outline-none cursor-pointer">
                Ajouter Role
            </button>
        </div>


        <table id="users-table" class="min-w-full mt-4 border">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Role</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Date de creation</th>
                <th class="px-4 py-2">Date de mise a jour</th>

                <th class="px-4 py-2">Action</th>
            </tr>
            </thead>
        </table>
        <!-- Include DataTables JS after jQuery -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#users-table').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.roles.data') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'description', name: 'description'},
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function (data) {
                                return moment(data).format('DD-MM-YYYY HH:mm');
                            }
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                            render: function (data) {
                                return moment(data).format('DD-MM-YYYY HH:mm');
                            }
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                return `
                        <button class="edit-btn px-3 py-1 text-sm font-medium text-white
                            bg-indigo-600 rounded hover:bg-indigo-700 focus:outline-none cursor-pointer" data-id="${row.id}">
                            Modifier
                        </button>
                        <button class="delete-btn px-3 py-1 text-sm
                                    font-medium text-white bg-red-600 rounded hover:bg-red-700
                                    focus:outline-none cursor-pointer" data-id="${row.id}">
                            Supprimer
                        </button>
                    `;
                            }
                        }
                    ],
                    dom: '<"flex justify-between items-center mb-4"<"flex-1"l><"flex-1"f><"text-right"B>>rtip',
                    language: {
                        search: "Rechercher:",
                        searchPlaceholder: "Rechercher..."
                    },


                });
            });
        </script>
    </div>


    {{--    modal de suppression --}}
    <!-- Modal de confirmation -->
    <div id="confirmDeleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Contenu du modal -->
            <div class="relative w-full max-w-md p-4 mx-auto bg-white rounded-lg shadow-lg">
                <div class="flex justify-between items-center pb-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Confirmation de suppression</h3>
                    <button id="closeModalButton" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="py-4">
                    <p class="text-gray-600">Êtes-vous sûr de vouloir supprimer ce role ?</p>
                </div>
                <div class="flex justify-end space-x-2">
                    <button id="cancelDeleteButton"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                        Annuler
                    </button>
                    <button id="confirmDeleteButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay (arrière-plan sombre) -->
    <div id="modalOverlay" class="fixed inset-0 z-40 hidden bg-black opacity-50"></div>



    {{--    Modal de suppression --}}
    <!-- Modal latéral -->
    <div id="editModal"
         class="fixed inset-y-0 right-0 z-50 w-full max-w-sm bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Modifier un Role</h3>
            <button id="closeEditModalButton" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <!-- Formulaire de modification -->
            <form id="editForm" method="POST">
                @csrf
                @method('PUT') <!-- Utilisé pour une requête PUT -->
                <input type="hidden" id="editUserId" name="id">

                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="editName" name="name"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" id="editDescription" name="description"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="flex justify-end">
                    <button id="closeEditModalButton2"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none mr-2">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700 focus:outline-none">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Overlay (arrière-plan sombre) -->
    <div id="editModalOverlay" class="fixed inset-0 z-40 hidden bg-black opacity-50"></div>



    {{--    Modal d'ajout--}}
    <!-- Modal latéral pour l'ajout -->
    <div id="createModal" class="fixed inset-y-0 right-0 z-50 w-full max-w-sm bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Ajouter un Role</h3>
            <button id="closeCreateModalButton" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-4">
            <!-- Formulaire de création -->
            <form id="createForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="createName" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="createName" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="createEmail" class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" id="createDescription" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex justify-end">
                    <button id="closeCreateModalButton2" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none mr-2">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700 focus:outline-none">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Overlay (arrière-plan sombre) -->
    <div id="createModalOverlay" class="fixed inset-0 z-40 hidden bg-black opacity-50"></div>

    <script>
        // Stocker l'ID de l'utilisateur à supprimer
        let deleteId = null;

        // Ouvrir le modal lorsqu'un bouton "Supprimer" est cliqué
        $(document).on('click', '.delete-btn', function () {
            deleteId = $(this).data('id'); // Récupérer l'ID de l'utilisateur
            $('#confirmDeleteModal').removeClass('hidden'); // Afficher le modal
            $('#modalOverlay').removeClass('hidden'); // Afficher l'overlay
        });

        // Fermer le modal lorsque l'utilisateur clique sur "Annuler" ou sur la croix
        $('#cancelDeleteButton, #closeModalButton, #modalOverlay').on('click', function () {
            $('#confirmDeleteModal').addClass('hidden'); // Masquer le modal
            $('#modalOverlay').addClass('hidden'); // Masquer l'overlay
        });

        // Exécuter la suppression lorsqu'on clique sur "Supprimer" dans le modal
        $('#confirmDeleteButton').on('click', function () {
            if (deleteId) {
                $.ajax({
                    url: `/admin/roles/${deleteId}`, // Route DELETE pour supprimer l'utilisateur
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token pour Laravel
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            //alert(response.message);
                            $('#confirmDeleteModal').addClass('hidden'); // Fermer le modal
                            $('#modalOverlay').addClass('hidden'); // Masquer l'overlay
                            $('#users-table').DataTable().ajax.reload(); // Recharger la table
                            // alert('Utilisateur supprimé avec succès !');
                        }

                    },
                    error: function (xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'Une erreur inattendue est survenue.';
                        alert(errorMessage);
                    }
                });
            }
        });
    </script>


    <script>
        // Gérer l'ouverture du modal lorsqu'un bouton "Modifier" est cliqué
        $(document).on('click', '.edit-btn', function() {
            const userId = $(this).data('id'); // Récupérer l'ID de l'utilisateur

            // Charger les données de l'utilisateur via une requête AJAX
            $.ajax({
                url: `/admin/roles/${userId}/edit`, // Route GET pour récupérer les données de l'utilisateur
                method: 'GET',
                success: function(response) {
                    // Remplir les champs du formulaire
                    $('#editUserId').val(response.id);
                    $('#editName').val(response.name);
                    $('#editDescription').val(response.description);

                    // Afficher le modal latéral
                    $('#editModal').removeClass('translate-x-full');
                    $('#editModalOverlay').removeClass('hidden');
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Une erreur inattendue est survenue.';
                    alert(errorMessage);
                }
            });
        });

        // Fermer le modal lorsque l'utilisateur clique sur "Annuler" ou sur la croix
        $('#closeEditModalButton, #closeEditModalButton2, #editModalOverlay').on('click', function() {
            $('#editModal').addClass('translate-x-full'); // Masquer le modal
            $('#editModalOverlay').addClass('hidden'); // Masquer l'overlay
        });

        // Gérer la soumission du formulaire de modification
        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            const userId = $('#editUserId').val(); // Récupérer l'ID de l'utilisateur
            const formData = $(this).serialize(); // Sérialiser les données du formulaire

            // Envoyer les données via une requête AJAX
            $.ajax({
                url: `/admin/roles/${userId}`, // Route PUT pour mettre à jour l'utilisateur
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token pour Laravel
                },
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal
                        $('#editModal').addClass('translate-x-full');
                        $('#editModalOverlay').addClass('hidden');

                        // Reload the DataTable
                        $('#users-table').DataTable().ajax.reload();

                        // Show a success message
                        //alert(response.message);
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Une erreur inattendue est survenue.';
                    alert(errorMessage);
                }
            });
        });
    </script>
    <script>
        // Ouvrir le modal lorsque le bouton "Ajouter Utilisateur" est cliqué
        $('#openCreateModalButton').on('click', function() {
            $('#createModal').removeClass('translate-x-full'); // Afficher le modal
            $('#createModalOverlay').removeClass('hidden'); // Afficher l'overlay
        });

        // Fermer le modal lorsque l'utilisateur clique sur "Annuler" ou sur la croix
        $('#closeCreateModalButton, #closeCreateModalButton2, #createModalOverlay').on('click', function() {
            $('#createModal').addClass('translate-x-full'); // Masquer le modal
            $('#createModalOverlay').addClass('hidden'); // Masquer l'overlay
        });

        $('#createForm').on('submit', function(e) {
            e.preventDefault(); // Empêcher la soumission traditionnelle

            const formData = {
                name: $('#createName').val(),
                description: $('#createDescription').val(),

            };

            $.ajax({
                url: '/admin/roles',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                data: $.param(formData), // CORRIGÉ : Utiliser `data` pour passer les données
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal
                        $('#createModal').addClass('translate-x-full');
                        $('#createModalOverlay').addClass('hidden');

                        // Reload the DataTable
                        $('#users-table').DataTable().ajax.reload();

                        // Show a success message
                        //alert(response.message);
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Une erreur inattendue est survenue.';
                    alert(errorMessage);
                }
            });
        });
    </script>
@endsection



