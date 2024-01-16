@extends('templates.index')

@section('title')
    Mon profil
@stop

@section('content')
<div class="container mx-auto pb-12">
    <div class="flex flex-wrap justify-center">
        <div class="w-full">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center creepster">
                    Mon Profil
                </h2>
                <form action="{{ route('user.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="username" class="block mb-1">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" class="w-full border rounded px-3 py-2 text-gray-700" value="{{ auth()->user()->username }}" />
                    </div>
                    <div>
                        <label for="email" class="block mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 text-gray-700" value="{{ auth()->user()->email }}" />
                    </div>
                    <div>
                        <label for="new-password" class="block mb-1">Nouveau mot de passe</label>
                        <input type="password" id="new-password" name="new_password" class="w-full border rounded px-3 py-2 text-gray-700" />
                    </div>
                    <div>
                        <label for="confirm-password" class="block mb-1">Confirmer le nouveau mot de passe</label>
                        <input type="password" id="confirm-password" name="new_password_confirmation" class="w-full border rounded px-3 py-2 text-gray-700" />
                    </div>
                    <div class="flex justify-between items-center">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Mettre à jour
                        </button>
                    </div>
                </form>
                <form action="{{ route('user.destroy', auth()->user()) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-500">
                        Supprimer le compte
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop