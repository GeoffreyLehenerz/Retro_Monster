
<aside class="w-full md:w-1/4 p-4">
    <!-- Formulaire de Recherche Full Texte -->
    <form action="{{ route('search') }}" method="GET" class="bg-gray-700 rounded-lg shadow-lg p-4 mb-6">
    @csrf
      <h2 class="font-bold text-lg mb-4">Recherche</h2>
      <input type="text" name="query" placeholder="votre recherche" class="w-full p-2 mb-4 bg-gray-800 rounded" />
      <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">
          Chercher
      </button>
  </form>
    <!-- Formulaire de Recherche par Critères -->
  <form action="{{ route('monster.filter') }}" method="GET" class="bg-gray-700 rounded-lg shadow-lg p-4">
    <h2 class="font-bold text-lg mb-4">Filtrer par Critères</h2>

    @php
        use App\Models\MonsterType;
        use App\Models\Rarety;

        $types = MonsterType::all();
        $rareties = Rarety::all();
    @endphp

    <!-- Type -->
    <select name="type" class="w-full p-2 mb-4 bg-gray-800 rounded">
        <option value="" disabled selected>Choisir un type</option>
        @foreach ($types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>

    <!-- Rareté -->
    <select name="rarete" class="w-full p-2 mb-4 bg-gray-800 rounded">
        <option value="" disabled selected>Choisir une rareté</option>
        @foreach ($rareties as $rarety)
            <option value="{{ $rarety->id }}">{{ $rarety->name }}</option>
        @endforeach
    </select>

      <!-- PV -->
    <div class="bg-gray-700 rounded-lg shadow-lg p-4 mb-4">
      <h2 class="font-bold text-lg mb-4">Filtrer par PV</h2>
      <div id="slider-pv-filter" class="mb-4"></div>
      <span id="slider-pv-value-filter"></span>
      <input type="hidden" id="min-pv-filter" name="min_pv" />
      <input type="hidden" id="max-pv-filter" name="max_pv" />
      <script>
        var sliderPvFilter = document.getElementById("slider-pv-filter");
        var minPvFilter = document.getElementById("min-pv-filter");
        var maxPvFilter = document.getElementById("max-pv-filter");
        var sliderPvValueFilter = document.getElementById("slider-pv-value-filter");

        noUiSlider.create(sliderPvFilter, {
          start: [0, 200], // Valeurs initiales pour min et max PV
          connect: true,
          range: {
            min: 0,
            max: 200,
          },
        });

        sliderPvFilter.noUiSlider.on("update", function (values, handle) {
          minPvFilter.value = values[0];
          maxPvFilter.value = values[1];
          sliderPvValueFilter.innerHTML = "PV: " + values.join(" - ");
        });
      </script>
    </div>

    <!-- Attaque -->
    <div class="bg-gray-700 rounded-lg shadow-lg p-4 mb-4">
      <h2 class="font-bold text-lg mb-4">Filtrer par Attaque</h2>
      <div id="slider-attaque-filter" class="mb-4"></div>
      <span id="slider-attaque-value-filter"></span>
      <input type="hidden" id="min-attaque-filter" name="min_attaque" />
      <input type="hidden" id="max-attaque-filter" name="max_attaque" />
      <script>
        var sliderAttaqueFilter = document.getElementById("slider-attaque-filter");
        var minAttaqueFilter = document.getElementById("min-attaque-filter");
        var maxAttaqueFilter = document.getElementById("max-attaque-filter");
        var sliderAttaqueValueFilter = document.getElementById("slider-attaque-value-filter");

        noUiSlider.create(sliderAttaqueFilter, {
          start: [0, 200], // Valeurs initiales pour min et max Attaque
          connect: true,
          range: {
            min: 0,
            max: 200,
          },
        });

        sliderAttaqueFilter.noUiSlider.on("update", function (values, handle) {
          minAttaqueFilter.value = values[0];
          maxAttaqueFilter.value = values[1];
          sliderAttaqueValueFilter.innerHTML = "Attaque: " + values.join(" - ");
        });
      </script>
    </div>


    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">
        Appliquer les filtres
    </button>
  </form>
</aside>