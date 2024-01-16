@extends('templates.index')

@section('title')
    Créez votre monstre
@stop

@section('content')
<div class="container mx-auto pb-12">
    <div class="flex flex-wrap justify-center">
        <div class="w-full">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center creepster">
                    Créez votre Monstre
                </h2>
                <form action="{{ route('monster.add') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block mb-1">Nom du monstres</label>
                        <input type="text" id="name" name="name" class="w-full border rounded px-3 py-2 text-gray-700" placeholder="Nom du monstres" />
                    </div>
                    <div>
                        <label for="description" class="block mb-1">Description du monstre</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            class="w-full border rounded px-3 py-2 text-gray-700" 
                            rows="4" 
                            placeholder="Décrivez votre monstre ici..."></textarea>
                    </div>
                    <div>
                        <label for="rarety" class="block mb-1">Rareté:</label>
                        <select name="rarety" id="rarety" class="w-full border rounded px-3 py-2 text-gray-700">
                            @foreach($rareties as $rarety)
                                <option value="{{ $rarety->id }}">{{ $rarety->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block mb-1">Type:</label>
                        <select name="type" id="type" class="w-full border rounded px-3 py-2 text-gray-700">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-row justify-between">
                        <!-- PV Slider -->
                        <div class="w-1/3 px-2">
                            <h2 class="font-bold text-lg mb-2">PV</h2>
                            <div id="slider-pv" class="mb-2"></div>
                            <span id="slider-pv-value"></span>
                            <input type="hidden" id="pv" name="pv" />
                        </div>

                        <!-- Attaque Slider -->
                        <div class="w-1/3 px-4">
                            <h2 class="font-bold text-lg mb-2">Attaque</h2>
                            <div id="slider-attack" class="mb-2"></div>
                            <span id="slider-attack-value"></span>
                            <input type="hidden" id="attack" name="attack" />
                        </div>

                        <!-- Défense Slider -->
                        <div class="w-1/3 px-2">
                            <h2 class="font-bold text-lg mb-2">Défense</h2>
                            <div id="slider-defense" class="mb-2"></div>
                            <span id="slider-defense-value"></span>
                            <input type="hidden" id="defense" name="defense" />
                        </div>
                    </div>

                    <div>
                        <label for="monster-image" class="block mb-1">Image du monstre</label>
                        <input 
                            type="file" 
                            id="monster-image" 
                            name="monster_image" 
                            class="w-full border rounded px-3 py-2 text-gray-700"
                            accept="image/*">
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Enregistrement de la créature
                        </button>
                    </div>
                </form>
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            </div>
        </div>
    </div>
</div>
<script>
    // Slider pour les PV
    var sliderPv = document.getElementById("slider-pv");
    var pv = document.getElementById("pv");
    var sliderPvValue = document.getElementById("slider-pv-value");

    noUiSlider.create(sliderPv, {
        start: 100, // Valeur initiale
        connect: [true, false],
        range: {
            min: 0,
            max: 200
        },
    });

    sliderPv.noUiSlider.on("update", function (value) {
        pv.value = Math.round(value[0]);;
        sliderPvValue.innerHTML = "PV: " + pv.value;
    });

    // Slider pour l'Attaque
    var sliderAttack = document.getElementById("slider-attack");
    var attack = document.getElementById("attack");
    var sliderAttackValue = document.getElementById("slider-attack-value");

    noUiSlider.create(sliderAttack, {
        start: 100, // Valeur initiale
        connect: [true, false],
        range: {
            min: 0,
            max: 200
        },
    });

    sliderAttack.noUiSlider.on("update", function (value) {
        attack.value = Math.round(value[0]);;
        sliderAttackValue.innerHTML = "Attaque: " + attack.value;
    });

    // Slider pour la Défense
    var sliderDefense = document.getElementById("slider-defense");
    var defense = document.getElementById("defense");
    var sliderDefenseValue = document.getElementById("slider-defense-value");

    noUiSlider.create(sliderDefense, {
        start: 100, // Valeur initiale
        connect: [true, false],
        range: {
            min: 0,
            max: 200
        },
    });

    sliderDefense.noUiSlider.on("update", function (value) {
        defense.value = Math.round(value[0]);;
        sliderDefenseValue.innerHTML = "Défense: " + defense.value;
    });
</script>
@stop