@extends('layouts.app')

@section('contenu')
    <form method="POST" action="{{ route('parties.store') }}">
        @csrf
        <button type="submit" class="btn">Nouvelle partie</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Créée le</th>
                <th>Statut</th>
                <th>Coups</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($parties as $partie)
                <tr>
                    <td>{{ $partie->id }}</td>
                    <td>{{ $partie->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="statut {{ $partie->estTerminee() ? 'finie' : 'en-cours' }}">
                            {{ $partie->statut() }}
                        </span>
                    </td>
                    <td>{{ $partie->coups_count }}</td>
                    <td>
                        <a href="{{ route('parties.show', $partie) }}" class="btn btn-secondaire">Reprendre</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucune partie pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection