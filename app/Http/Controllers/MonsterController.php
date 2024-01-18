<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Monster;
use App\Models\Rarety;
use App\Models\MonsterType;
use Illuminate\Support\Facades\Auth;

class MonsterController extends Controller
{

    public function register()
    {
        $monsters = auth()->user()->monsters;
        $rareties = Rarety::all();
        $types = MonsterType::all();
        return view('monster.management', compact('monsters', 'rareties', 'types'));
    }

    public function add(Request $request)
    {
        $request->merge([
            'pv' => (int) $request->pv,
            'attack' => (int) $request->attack,
            'defense' => (int) $request->defense,
        ]);
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'rarety' => 'required|exists:rareties,id',
            'type' => 'required|exists:monster_types,id',
            'pv' => 'required|integer|min:0|max:200',
            'attack' => 'required|integer|min:0|max:200',
            'defense' => 'required|integer|min:0|max:200',
            'monster_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        // Initialiser la variable imageName
        $imageName = null;

        // Gérer l'upload de l'image
        if ($request->hasFile('monster_image')) {
            $originalName = str_replace(' ', '-', strtolower($request->name));
            $imageName = $originalName . '.' . $request->monster_image->extension();

            // Stocker l'image dans le dossier storage/app/public/images
            $request->monster_image->storeAs('public/images', $imageName);
        }

        // Créer un nouveau monstre
        $monster = new Monster;
        $monster->name = $validatedData['name'];
        $monster->description = $validatedData['description'];
        $monster->rarety_id = $validatedData['rarety'];
        $monster->type_id = $validatedData['type'];
        $monster->pv = $validatedData['pv'];
        $monster->attack = $validatedData['attack'];
        $monster->defense = $validatedData['defense'];
        $monster->image_url = $imageName;
        $monster->user_id = auth()->id();

        // Enregistrer le monstre dans la base de données
        $monster->save();

        // Rediriger vers une page avec un message de succès
        return redirect()->route('pages.home');
    }

    public function update(Request $request, $id)
    {
        // Trouver le monstre à mettre à jour
        $monster = Monster::findOrFail($id);

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'rarety' => 'required|exists:rareties,id',
            'type' => 'required|exists:monster_types,id',
            'pv' => 'required|integer|min:0|max:200',
            'attack' => 'required|integer|min:0|max:200',
            'defense' => 'required|integer|min:0|max:200',
            'monster_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Gérer l'upload de l'image si elle est fournie
        if ($request->hasFile('monster_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($monster->image_url && file_exists(storage_path('app/public/images/' . $monster->image_url))) {
                unlink(storage_path('app/public/images/' . $monster->image_url));
            }

            // Processus pour télécharger la nouvelle image
            $originalName = str_replace(' ', '-', strtolower($request->name));
            $imageName = $originalName . '.' . $request->monster_image->extension();
            $request->monster_image->storeAs('public/images', $imageName);

            // Mettre à jour l'URL de l'image du monstre
            $monster->image_url = $imageName;
        }

        // Mettre à jour les attributs du monstre
        $monster->name = $validatedData['name'];
        $monster->description = $validatedData['description'];
        $monster->rarety_id = $validatedData['rarety'];
        $monster->type_id = $validatedData['type'];
        $monster->pv = $validatedData['pv'];
        $monster->attack = $validatedData['attack'];
        $monster->defense = $validatedData['defense'];

        // Enregistrer les modifications
        $monster->save();

        // Rediriger vers une page avec un message de succès
        return redirect()->route('pages.home')->with('success', 'Monstre mis à jour avec succès!');
    }

    public function delete($id)
    {
        $monster = Monster::findOrFail($id);

        // Supprimer l'image si elle existe
        if ($monster->image_url && file_exists(storage_path('app/public/images/' . $monster->image_url))) {
            unlink(storage_path('app/public/images/' . $monster->image_url));
        }

        // Supprimer le monstre
        $monster->delete();

        // Rediriger vers une page avec un message de succès
        return redirect()->route('pages.home')->with('success', 'Monstre supprimé avec succès!');
    }

    public function filter(Request $request)
    {
        $query = Monster::query();

        // Filtre par type
        if ($request->has('type') && $request->type != '') {
            $query->whereHas('monsterType', function ($q) use ($request) {
                $q->where('type_id', $request->type);
            });
        }

        // Filtre par rareté
        if ($request->has('rarete') && $request->rarete != '') {
            $query->whereHas('rarety', function ($q) use ($request) {
                $q->where('rarety_id', $request->rarete);
            });
        }

        // Filtre par PV (Points de Vie)
        if ($request->has('min_pv') && $request->has('max_pv')) {
            $minPv = (int)$request->min_pv;
            $maxPv = (int)$request->max_pv;
            $query->whereBetween('pv', [$minPv, $maxPv]);
        }

        // Filtre par Attaque
        if ($request->has('min_attaque') && $request->has('max_attaque')) {
            $minAttaque = (int)$request->min_attaque;
            $maxAttaque = (int)$request->max_attaque;
            $query->whereBetween('attack', [$minAttaque, $maxAttaque]);
        }

        $monsters = $query->get();
        $users = collect(); // Créer une collection vide pour $users

        return view('search.results', compact('monsters', 'users'));
    }
}
