@extends('templates.index')

@section ('title')
    index des monstres
@stop

@section('content')
@php
    $users = \App\Models\User::orderBy('username', 'ASC')->paginate(9);
@endphp
<h2 class="text-2xl font-bold mb-4 creepster">
    Index des utilisateurs
</h2>
<!-- User Item -->
@include('user._index', $users)

<div class="mt-8 flex justify-center">{{$users->links()}}</div>
@stop