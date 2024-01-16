@php
$favoritesIds = [];
if (auth()->check()) {
    $favoritesIds = auth()->user()->favorites->pluck('monster_id')->toArray();
}
@endphp
<section class="mb-20">
    <div class="bg-gray-700 rounded-lg shadow-lg monster-card" data-monster-type="{{ strtolower($monster->monsterType->name) }}">
        <div class="md:flex">
            <!-- Image du monstre -->
            <div class="w-full md:w-1/2 relative">
              <img class="w-full h-full object-cover rounded-t-lg md:rounded-l-lg md:rounded-t-none" src="storage/images/{{$monster->image_url}}" alt="{{$monster->name}}"/>
              <div class="absolute top-4 right-4">
                <button class="text-white {{ in_array($monster->id, $favoritesIds) ? 'bg-red-700' : 'bg-gray-400' }} hover:bg-red-700 rounded-full p-2 transition-colors duration-300" style="width: 40px;height: 40px;display: flex;justify-content: center;align-items: center;">
                    <i class="fa fa-bookmark"></i>
                </button>
            </div>
        </div>

        <!-- Détails du monstre -->
        <div class="p-6 md:w-1/2">
            <h2 class="text-3xl font-bold mb-2 creepster">
                {{$monster->name}}
            </h2>
            <p class="text-gray-300 text-sm mb-4">
                {{$monster->description}}
            </p>
            <div class="mb-4">
                <strong class="text-white">Créateur:</strong>
                <span class="text-red-400">{{$monster->user->username}}</span>
            </div>
            <div class="mb-4">
                <div>
                    <strong class="text-white">Type:</strong>
                    <span class="text-gray-300">{{$monster->monsterType->name}}</span>
                </div>
                <div>
                    <strong class="text-white">PV:</strong>
                    <span class="text-gray-300">{{$monster->pv}}</span>
                </div>
                <div>
                    <strong class="text-white">Attaque:</strong>
                    <span class="text-gray-300">{{$monster->attack}}</span>
                </div>
                <div>
                    <strong class="text-white">Défense:</strong>
                    <span class="text-gray-300">{{$monster->defense}}</span>
                </div>
            </div>
            <div class="mb-4">
                @php
                    $note = $monster->monsterAverage->average_note ?? 0;
                    $fullStars = floor($note);
                    $halfStar = ($note - $fullStars) > 0 ? 1 : 0;
                    $emptyStars = 5 - $fullStars - $halfStar;
                @endphp
            
                @for ($i = 0; $i < $fullStars; $i++)
                    <span class="text-yellow-400">&#9733;</span> <!-- étoile pleine -->
                @endfor
            
                @if ($halfStar)
                    <span class="text-yellow-400">&#9734;</span> <!-- demi-étoile -->
                @endif
            
                @for ($i = 0; $i < $emptyStars; $i++)
                    <span class="text-gray-300">&#9734;</span> <!-- étoile vide -->
                @endfor
            
                <span class="text-gray-300 text-sm">
                    @if ($monster->monsterAverage)
                        {{ number_format($note, 1) }}/5.0
                    @else
                        Pas encore de note
                    @endif
                </span>
            </div>
            
            <div>
                <a href="{{ route('monsters.show',['id'=> $monster->id,'slug' => \Illuminate\Support\Str::slug( $monster->name, '-')]) }}" class="inline-block text-white bg-red-500 hover:bg-red-700 rounded-full px-4 py-2 transition-colors duration-300">
                    Plus de détails
                </a>
            </div>
        </div>
    </div>
</section>