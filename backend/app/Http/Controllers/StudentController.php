<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::with('user')->findOrFail($id);
        return view('espace_etudiants.Edit_info', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
        ]);

        // Update user
        $user = $student->user;
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads'), $fileName);
            $user->image = 'uploads/' . $fileName;
        }

        $user->save();
        // Update Student info
        $student->phone = $request->phone;
        $student->date_of_birth = $request->date_of_birth;
        $student->save();

        return redirect()->route('students.edit', $student->id)->with('success', 'Infos modifiées avec succès');
    }

    // Générer PDF
    public function generatePdf($id)
    {
        $student = Student::with('user')->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('espace_etudiants.components.pdf', compact('student'));
        return $pdf->download('student_' . $student->id . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
