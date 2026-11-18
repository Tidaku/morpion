<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Morpion</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background: #f1f3f8;
            color: #1f2937;
        }

        /* En-tête */
        .entete { background: #1e293b; color: white; padding: 1em 0; text-align: center; }
        .entete h1 { margin: 0; font-size: 1.8em; letter-spacing: 0.05em; }

        /* Carte centrale */
        main {
            max-width: 760px;
            margin: 2em auto;
            padding: 2em;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Boutons */
        .btn {
            display: inline-block;
            padding: 0.6em 1.2em;
            border: none;
            border-radius: 8px;
            background: #4f46e5;
            color: white;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover { background: #4338ca; }
        .btn-secondaire { background: #e5e7eb; color: #1f2937; }
        .btn-secondaire:hover { background: #d1d5db; }

        /* Plateau */
        .plateau { display: grid; gap: 6px; grid-template-columns: repeat(3, 90px); }
        .case {
            height: 90px;
            font-size: 2.8em;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 2px solid #cbd5e1;
            border-radius: 10px;
        }
        button.case { cursor: pointer; transition: background 0.15s; }
        button.case:hover { background: #e0e7ff; }
        .case-X { color: #2563eb; }
        .case-O { color: #dc2626; }

        /* Mise en page plateau + historique */
        .jeu { display: flex; gap: 2.5em; align-items: flex-start; flex-wrap: wrap; }
        .actions { display: flex; gap: 0.5em; margin-top: 1em; }
        .historique { min-width: 180px; }
        .historique h3 { margin-top: 0; }
        .historique p { margin: 0.25em 0; }

        /* Messages */
        .tour { font-size: 1.2em; }
        .resultat { font-size: 1.5em; font-weight: bold; color: #059669; }
        .erreur { background: #fee2e2; color: #b91c1c; padding: 0.6em 1em; border-radius: 8px; }
        .retour { display: inline-block; margin-bottom: 1em; color: #4f46e5; text-decoration: none; }
        .retour:hover { text-decoration: underline; }

        /* Tableau des parties */
        table { width: 100%; border-collapse: collapse; margin-top: 1.5em; }
        th, td { padding: 0.6em; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f1f5f9; }
        tbody tr:hover td { background: #f8fafc; }

        /* Badges de statut */
        .statut { padding: 0.2em 0.7em; border-radius: 999px; font-size: 0.85em; }
        .en-cours { background: #fef3c7; color: #92400e; }
        .finie { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <header class="entete">
        <h1>Morpion</h1>
    </header>
    <main>
        @yield('contenu')
    </main>
</body>
</html>