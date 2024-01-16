<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @php
    $favoritesIds = [];
    if (auth()->check()) {
        $favoritesIds = auth()->user()->favorites->pluck('monster_id')->toArray();
    }
    @endphp
    @foreach ($monsters as $monster)
        <!-- Monster Item -->
        <article class="relative bg-gray-700 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 monster-card" data-monster-type="{{strtolower($monster->monsterType->name)}}">
            <img class="w-full h-48 object-cover rounded-t-lg" src="storage/images/{{$monster->image_url}}" alt="{{$monster->name}}"/>
            <div class="p-4">
                <h3 class="text-xl font-bold">
                    {{$monster->name}}
                </h3>
                <h4 class="mb-2">
                    <a href="#" class="text-red-400 hover:underline">
                        {{$monster->user->username}}
                    </a>
                </h4>
                <p class="text-gray-300 text-sm mb-2">
                    {{$monster->description}}
                </p>
                <div class="flex justify-between items-center mb-2">
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
                    
                    <span class="text-sm text-gray-300">Type: {{$monster->monsterType->name}}</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-300">PV: {{$monster->pv}}</span>
                    <span class="text-sm text-gray-300">Attaque: {{$monster->attack}}</span>
                    <span class="text-sm text-gray-300">Défense: {{$monster->defense}}</span>
                </div>
                <div class="text-center">
                    <a href="{{ route('monsters.show',['id'=> $monster->id,'slug' => \Illuminate\Support\Str::slug( $monster->name, '-')]) }}" class="inline-block text-white bg-red-500 hover:bg-red-700 rounded-full px-4 py-2 transition-colors duration-300">
                        Plus de détails
                    </a>
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <button class="text-white {{ in_array($monster->id, $favoritesIds) ? 'bg-red-700' : 'bg-gray-400' }} hover:bg-red-700 rounded-full p-2 transition-colors duration-300" style="width: 40px;height: 40px;display: flex;justify-content: center;align-items: center;">
                    <i class="fa fa-bookmark"></i>
                </button>
            </div>
        </article>
    @endforeach
</div>