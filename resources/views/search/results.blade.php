@extends('templates.index')

@section ('title')
    Résultat de votre recherches
@stop

@section('content')

<h2 class="text-2xl font-bold mb-4 creepster">
    Résultat de votre recherches
</h2>
<!-- User Item -->
@include('monster._index', $monsters)

@include('user._index', $users)

@stop