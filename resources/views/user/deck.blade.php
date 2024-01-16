@extends('templates.index')

@section ('title')
    Mon deck
@stop

@section('content')

<h2 class="text-2xl font-bold mb-4 creepster">
    Mon deck
</h2>
<!-- Monster Item -->
@include('monster._index', $monsters)
@stop