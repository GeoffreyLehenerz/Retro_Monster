<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Validez et mettez à jour les données de l'utilisateur
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'new_password' => 'nullable|confirmed', // Ajoutez cette ligne
        ]);

        // Vérifiez et mettez à jour le mot de passe si nécessaire
        if ($request->filled('new_password')) {
            $user->password = bcrypt($request->input('new_password'));
        }

        $user->update($validatedData);

        return redirect()->route('pages.home')->with('success', 'Profil mis à jour avec succès.');
    }
}
