@extends('layouts.StudentLayout')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-xl font-bold mb-4">Formulaire Informations Etudiants</h1>

        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nom --}}
            <div class="mb-4">
                <label class="block font-medium">Nom</label>
                <input type="text" name="name" value="{{ old('name', $student->user->name) }}"
                       class="w-full border rounded p-2">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $student->user->email) }}"
                       class="w-full border rounded p-2">
            </div>
            {{-- Phone (Student) --}}
            <div class="mb-4">
                <label class="block font-medium">Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                       class="w-full border rounded p-2">
            </div>

            {{-- Date of Birth (Student) --}}
            <div class="mb-4">
                <label class="block font-medium">Date de naissance</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}"
                       class="w-full border rounded p-2">
            </div>
            {{-- Image --}}
            <div class="mb-4">
                <label class="block font-medium">Image</label>
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                <div class="mt-2">
                    <img id="preview" src="{{ asset($student->user->image) }}"
                         class="w-32 h-32 rounded border object-cover">
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Modifier</button>
                <a href="{{ route('students.pdf', $student->id) }}" class="bg-green-500 text-white px-4 py-2 rounded">
                    Imprimer PDF
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            let output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
