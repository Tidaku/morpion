<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partie extends Model
{
    // Les 8 alignements gagnants : 3 lignes, 3 colonnes, 2 diagonales
    private const ALIGNEMENTS = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],
        [0, 3, 6], [1, 4, 7], [2, 5, 8],
        [0, 4, 8], [2, 4, 6],
    ];

    protected $fillable = ['plateau', 'joueur_courant'];

    protected $attributes = [
        'plateau' => '---------',
        'joueur_courant' => 'X',
    ];

    // Une partie a plusieurs coups
    public function coups(): HasMany
    {
        return $this->hasMany(Coup::class);
    }

    // Transforme "X-O------" en ['X', '-', 'O', '-', ...]
    public function cases(): array
    {
        return str_split($this->plateau);
    }

    // Une case est libre si elle contient '-'
    public function caseLibre(int $position): bool
    {
        return $this->plateau[$position] === '-';
    }

    // Pose le symbole du joueur courant, change de joueur, sauvegarde, enregistre le coup
    public function placer(int $position): void
    {
        $symbole = $this->joueur_courant;

        $plateau = $this->plateau;
        $plateau[$position] = $symbole;
        $this->plateau = $plateau;

        $this->joueur_courant = $symbole === 'X' ? 'O' : 'X';
        $this->save();

        $this->coups()->create([
            'position' => $position,
            'symbole'  => $symbole,
        ]);
    }

    // Renvoie 'X', 'O' ou null
    public function gagnant(): ?string
    {
        $cases = $this->cases();

        foreach (self::ALIGNEMENTS as [$a, $b, $c]) {
            if ($cases[$a] !== '-' && $cases[$a] === $cases[$b] && $cases[$b] === $cases[$c]) {
                return $cases[$a];
            }
        }

        return null;
    }

    // Plateau plein sans gagnant
    public function estNulle(): bool
    {
        return $this->gagnant() === null && ! str_contains($this->plateau, '-');
    }

    public function estTerminee(): bool
    {
        return $this->gagnant() !== null || $this->estNulle();
    }

    // Supprime le dernier coup et restaure l'état précédent
    public function annulerDernierCoup(): void
    {
        $dernier = $this->coups()->latest('id')->first();

        if ($dernier === null) {
            return;
        }

        $plateau = $this->plateau;
        $plateau[$dernier->position] = '-';
        $this->plateau = $plateau;

        $this->joueur_courant = $dernier->symbole;
        $this->save();

        $dernier->delete();
    }

    // "En cours", "Gagnée par X", "Gagnée par O" ou "Match nul"
    public function statut(): string
    {
        $gagnant = $this->gagnant();

        if ($gagnant !== null) {
            return 'Gagnée par ' . $gagnant;
        }

        if ($this->estNulle()) {
            return 'Match nul';
        }

        return 'En cours';
    }
}