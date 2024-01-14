@extends('templates.index')

@section ('title')
    index des monstres
@stop

@section('content')
@php
    $monsters = \App\Models\Monster::orderBy('name', 'ASC')->paginate(9);
@endphp
<h2 class="text-2xl font-bold mb-4 creepster">
    Index de tous les monstres
</h2>
<!-- Monster Item -->
@include('monster._index', $monsters)

<div class="mt-8 flex justify-center">{{$monsters->links()}}</div>
@stop