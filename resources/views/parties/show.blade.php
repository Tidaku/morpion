@extends('layouts.app')

@section('contenu')
    <a href="{{ route('parties.index') }}" class="retour">← Toutes les parties</a>

    {{-- Résultat ou joueur courant --}}
    @if ($partie->estTerminee())
        @if ($partie->gagnant())
            <p class="resultat">{{ $partie->gagnant() }} a gagné !</p>
        @else
            <p class="resultat">Match nul</p>
        @endif
    @else
        <p class="tour">Au tour de : <strong class="case-{{ $partie->joueur_courant }}">{{ $partie->joueur_courant }}</strong></p>
    @endif

    @error('position')
        <p class="erreur">{{ $message }}</p>
    @enderror

    <div class="jeu">
        {{-- Colonne de gauche : plateau + boutons --}}
        <div>
            <form method="POST" action="{{ route('parties.jouer', $partie) }}">
                @csrf
                <div class="plateau">
                    @foreach ($cases as $i => $case)
                        @if ($case === '-' && ! $partie->estTerminee())
                            <button class="case" name="position" value="{{ $i }}"></button>
                        @else
                            <div class="case case-{{ $case }}">{{ $case === '-' ? '' : $case }}</div>
                        @endif
                    @endforeach
                </div>
            </form>

            <div class="actions">
                @if ($coups->isNotEmpty())
                    <form method="POST" action="{{ route('parties.annuler', $partie) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondaire">Annuler le dernier coup</button>
                    </form>
                @endif

                @if ($partie->estTerminee())
                    <form method="POST" action="{{ route('parties.store') }}">
                        @csrf
                        <button type="submit" class="btn">Nouvelle partie</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Colonne de droite : historique --}}
        <div class="historique">
            <h3>Historique</h3>
            @forelse ($coups as $coup)
                <p>{{ $loop->iteration }}. <span class="case-{{ $coup->symbole }}">{{ $coup->symbole }}</span> en case {{ $coup->position }}</p>
            @empty
                <p>Aucun coup joué.</p>
            @endforelse
        </div>
    </div>
@endsection