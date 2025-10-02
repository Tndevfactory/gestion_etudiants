<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Info Student</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        img { max-width: 150px; height: auto; }
    </style>
</head>
<body>
<h2>Informations de l'étudiant(e)</h2>


@if($student->user->image)
    <img src="{{ public_path($student->user->image) }}">
@endif

<p><strong>Nom :</strong> {{ $student->user->name }}</p>
<p><strong>Email :</strong> {{ $student->user->email }}</p>
<p><strong>Téléphone :</strong> {{ $student->phone }}</p>
<p><strong>Date de naissance :</strong> {{ $student->date_of_birth }}</p>

</body>
</html>
