<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monster;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Recherche de monstres
        $monsters = Monster::search($query)->get();

        $users = User::search($query)->get();

        return view('search.results', compact('monsters', 'users'));
    }
}
