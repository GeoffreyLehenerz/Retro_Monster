@extends('templates.index')

@section('title')
    Créez votre compte
@stop

@section('content')
<div class="container mx-auto pb-12">
    <div class="flex flex-wrap justify-center">
        <div class="w-full">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center creepster">
                    Créez votre compte
                </h2>
                <form action="{{ route('user.add') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="username" class="block mb-1">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" class="w-full border rounded px-3 py-2 text-gray-700" placeholder="Votre nom d'utilisateur" />
                    </div>
                    <div>
                        <label for="email" class="block mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 text-gray-700" placeholder="Votre email" />
                    </div>
                    <div>
                        <label for="new-password" class="block mb-1">Mot de passe</label>
                        <input type="password" id="new-password" name="new_password" class="w-full border rounded px-3 py-2 text-gray-700" placeholder="Votre mot de passe" />
                    </div>
                    <div>
                        <label for="confirm-password" class="block mb-1">Confirmer le mot de passe</label>
                        <input type="password" id="confirm-password" name="new_password_confirmation" class="w-full border rounded px-3 py-2 text-gray-700" placeholder="Confirmez votre mot de passe" />
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            S'inscrire
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop