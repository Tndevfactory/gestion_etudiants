<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::with(['role', 'teacher'])
            ->whereHas('teacher')
            ->whereHas('role', fn($q) => $q->where('name', '!=', 'admin'))
            ->when($search, fn($query, $search) => $query->where(fn($q) => $q
                ->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")))
            ->paginate(10);

        return view('admin.users.index',
            compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'teacher.phone'     => 'nullable|string|max:20',
            'teacher.specialty' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $imageName);
            $data['image'] = 'uploads/' . $imageName;

        }

        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = 2; // role teacher
        $user = User::create($data);

        // Création du teacher correctement
        $teacherData = $request->input('teacher', []);
        if (!empty($teacherData['phone']) || !empty($teacherData['specialty'])) {
            $user->teacher()->create([
                'phone'     => $teacherData['phone'] ?? null,
                'specialty' => $teacherData['specialty'] ?? null,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function update(Request $request, User $user)
    {
        // Validation
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|min:6',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'teacher.phone'     => 'nullable|string|max:20',
            'teacher.specialty' => 'nullable|string|max:255',
        ]);

        // Gestion image
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $imageName);
            $data['image'] = 'uploads/' . $imageName;
        }

        // Gestion mot de passe si rempli
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']); // éviter d'écraser le password existant
        }

        // Forcer role teacher
        $data['role_id'] = 2;

        // Update user
        $user->update($data);

        // Update ou create teacher
        $teacherData = $request->input('teacher', []);
        if (!empty($teacherData['phone']) || !empty($teacherData['specialty'])) {
            $user->teacher()->updateOrCreate(
                ['id' => $user->id],
                [
                    'phone'     => $teacherData['phone'] ?? null,
                    'specialty' => $teacherData['specialty'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.users.index') ->with('success', 'Teacher updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete(); // cascade teacher si relation configurée
        return redirect()->route('admin.users.index') ->with('success', 'Teacher deleted successfully.');
    }
}
