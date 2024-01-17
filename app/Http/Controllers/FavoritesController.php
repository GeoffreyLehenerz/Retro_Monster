<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    public function addToFavorites(Request $request, $monsterId)
    {
        $userId = auth()->user()->id;

        // Vérifier si le monstre est déjà dans les favoris
        $exists = DB::table('favorites')->where('user_id', $userId)->where('monster_id', $monsterId)->exists();

        if ($exists) {
            // Si déjà dans les favoris, on le retire
            DB::table('favorites')->where('user_id', $userId)->where('monster_id', $monsterId)->delete();
            return response()->json(['success' => true, 'removed' => true]);
        } else {
            // Sinon, on l'ajoute aux favoris
            DB::table('favorites')->insert([
                'user_id' => $userId,
                'monster_id' => $monsterId,
                'created_at' => now(),
            ]);
            return response()->json(['success' => true, 'added' => true]);
        }
    }
}
