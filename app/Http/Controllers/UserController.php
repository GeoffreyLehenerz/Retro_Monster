<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

    public function destroy(User $user)
    {
        // Assurez-vous que l'utilisateur authentifié supprime uniquement son propre compte
        if (auth()->id() !== $user->id) {
            return redirect()->back()->withErrors(['message' => 'Action non autorisée.']);
        }

        // Suppression de l'utilisateur
        $user->delete();

        // Déconnexion de l'utilisateur
        auth()->logout();

        // Redirection avec un message de succès
        return redirect()->route('pages.home')->with('success', 'Compte supprimé avec succès.');
    }

    public function add(Request $request)
    {

        // Valider les données reçues du formulaire
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'new_password' => 'required|string|confirmed',
        ]);

        // Créer un nouvel utilisateur
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['new_password']),
        ]);

        // Connecter l'utilisateur après l'inscription
        auth()->login($user);

        // Rediriger vers la page d'accueil ou une autre page souhaitée
        return redirect()->route('pages.home')->with('success', 'Compte créé avec succès et connexion réussie.');
    }
}
