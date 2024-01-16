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
        $rareties = Rarety::all();
        $types = MonsterType::all();
        return view('monster.register', compact('rareties', 'types'));
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
}
