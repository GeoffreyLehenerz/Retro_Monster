@extends('templates.index')

@section('title')
Gérez vos Monstres
@stop

@section('content')
<div class="container mx-auto pb-12">
    <div class="flex flex-wrap justify-center">
        <div class="w-full">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center creepster">
                    Gérez vos Monstres
                </h2>
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Menu Déroulant pour Sélectionner un Monstre Existant -->
                    <div>
                        <label for="existing-monster" class="block mb-1">Sélectionnez un Monstre:</label>
                        <select name="existing_monster" id="existing-monster" class="w-full border rounded px-3 py-2 text-gray-700" onchange="updateForm()">
                            <option value="">--Nouveau Monstre--</option>
                            @foreach($monsters as $monster)
                                <option value="{{ $monster->id }}">{{ $monster->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Supprimer
                        </button>
                    </div>
                </form>
                <form id="monster-form" action="{{ route('monster.add') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="form-method">
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
            </div>
        </div>
    </div>
</div>
<script>

    function updateForm() {
        var monsters = @json($monsters);
        var form = document.getElementById('monster-form');
        var selectedMonsterId = document.getElementById('existing-monster').value;

        if(selectedMonsterId) {
            var selectedMonster = monsters.find(monster => monster.id == selectedMonsterId);

            // Mettre à jour les champs du formulaire
            document.getElementById('name').value = selectedMonster.name;
            document.getElementById('description').value = selectedMonster.description;

            // Mise à jour des menus déroulants de rareté et de type
            document.getElementById('rarety').value = selectedMonster.rarety_id;
            document.getElementById('type').value = selectedMonster.type_id;

            // Mise à jour des sliders
            sliderPv.noUiSlider.set(selectedMonster.pv);
            sliderAttack.noUiSlider.set(selectedMonster.attack);
            sliderDefense.noUiSlider.set(selectedMonster.defense);

            //modifier la cible du formulaire
            form.action = 'http://127.0.0.1:8000/monster/update/' + selectedMonsterId;
            document.getElementById('form-method').value = 'PUT';

            // Modifier le texte du bouton de soumission
            document.querySelector('button[type="submit"]').textContent = 'Éditer la créature';
        } else {
            // Réinitialiser le formulaire
            document.getElementById('name').value = "";
            document.getElementById('description').value = "";

            // Mise à jour des menus déroulants de rareté et de type
            document.getElementById('rarety').value = 0;
            document.getElementById('type').value = 0;

            // Mise à jour des sliders
            sliderPv.noUiSlider.set(100);
            sliderAttack.noUiSlider.set(100);
            sliderDefense.noUiSlider.set(100);

            //modifier la cible du formulaire
            form.action = '{{ route("monster.add") }}';

            //modifier la cible du formulaire
            document.querySelector('button[type="submit"]').textContent = 'Enregistrement de la créature';
            document.getElementById('form-method').value = 'POST';
        }
    }

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