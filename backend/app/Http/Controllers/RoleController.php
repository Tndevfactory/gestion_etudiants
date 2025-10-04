<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {

        return view('admin.roles.index');
    }
    public function getData()
    {
        return DataTables::of(Role::query()->orderBy('id', 'desc'))->make(true);
    }
    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {

        try {
            // Valider les données
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable',
            ]);

            // Créer l'utilisateur
            $role = Role::create($validatedData);

            // Retourner une réponse JSON en cas de succès
            return response()->json([
                'status' => 'success',
                'message' => 'role ajouté avec succès.',
                'data' => $role,
            ], 201);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'message' => 'Veuillez corriger les erreurs ci-dessous.',
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du role : ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de l\'ajout du role.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function edit(Role $role)
    {
        return response()->json($role);
    }
    public function update(Request $request, Role $role)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable',
            ]);

            // Update the role with the validated data
            $role->update($request->all());

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'role modifié avec succès.',
                'data' => $role, // Optionally include the updated user data
            ], 200); // HTTP status code 200 for success
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la modification.',
                'error' => $e->getMessage(), // Optional: Include the error message for debugging
            ], 500); // HTTP status code 500 for server error
        }
    }

    public function destroy(Role $role)
    {
        try {
            // Delete the user
            $role->delete();
            // Return a success JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'Role supprimé avec succès.',
            ], 200); // HTTP status code 200 for success
        } catch (\Exception $e) {
            // Return an error JSON response if something goes wrong
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression.',
                'error' => $e->getMessage(), // Optional: Include the error message for debugging
            ], 500); // HTTP status code 500 for server error
        }
    }
}
