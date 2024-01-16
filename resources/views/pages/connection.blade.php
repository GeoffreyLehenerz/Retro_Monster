@extends('templates.index')

@section('title')
    Connexion
@stop

@section('content')
<div class="container mx-auto flex justify-center items-center">
    <div class="w-full">
      <form action="{{ route('login') }}" method="POST" class="bg-gray-700 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-300 text-sm font-bold mb-2" for="username">
          Mail de l'utilisateur
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="email" type="email" placeholder="Mail de l'utilisateur"/>
        </div>
        <div class="mb-6">
          <label class="block text-gray-300 text-sm font-bold mb-2" for="password">
            Mot de passe
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="password" type="password" placeholder="******************"/>
        </div>
        <div class="flex items-center justify-between">
          <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Se connecter
          </button>
          <a class="inline-block align-baseline font-bold text-sm text-red-400 hover:text-red-500" href="#">
            Mot de passe oublié ?
          </a>
          <a class="text-red-400 hover:text-red-500 font-bold text-sm" href="{{ route('user.register') }}">
            Créer un compte
          </a>
        </div>
      </form>
    </div>
  </div>
@stop