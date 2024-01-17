<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notation;

class NotationController extends Controller
{
    public function store(Request $request)
    {
        $user_id = auth()->id();
        $monster_id = $request->monster_id;
        $rating = $request->rating;

        // Vérifier si l'utilisateur a déjà noté ce monstre
        $exists = DB::table('notations')
            ->where('user_id', $user_id)
            ->where('monster_id', $monster_id)
            ->exists();

        if ($exists) {
            // Mise à jour de la note si elle existe déjà
            DB::table('notations')
                ->where('user_id', $user_id)
                ->where('monster_id', $monster_id)
                ->update(['notation' => $rating]);
        } else {
            // Créer une nouvelle note
            DB::table('notations')->insert([
                'user_id' => $user_id,
                'monster_id' => $monster_id,
                'notation' => $rating
            ]);
        }

        return response()->json(['message' => 'Note enregistrée avec succès']);
    }
}
