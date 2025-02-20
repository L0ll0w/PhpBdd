@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Liste des Rendez-vous</h2>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Date du Rendez-vous</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->user->name ?? 'Inconnu' }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>{{ $appointment->details }}</td>
                        <td>
                            <form action="{{ route('admin.rdv.delete', $appointment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
