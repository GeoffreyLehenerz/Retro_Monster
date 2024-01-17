@extends('templates.index')

@section ('title')
    {{$monster->name}}
@stop

@section('content')
@php
$favoritesIds = [];
if (auth()->check()) {
    $favoritesIds = auth()->user()->favorites->pluck('monster_id')->toArray();
}
@endphp
<div class="container mx-auto flex flex-wrap pb-12">
    <!-- Page de détail du monstre -->
    <section class="w-full">
      <section class="mb-20">
        <div class="bg-gray-700 rounded-lg shadow-lg monster-card" data-monster-type="{{strtolower($monster->monsterType->name)}}">
          <div class="md:flex">
            <!-- Image du monstre -->
            <div class="w-full md:w-1/2 relative">
              <img class="w-full h-full object-cover rounded-t-lg md:rounded-l-lg md:rounded-t-none" src="{{asset('storage/images/' . $monster->image_url) }}" alt="{{$monster->name}}"/>
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
            
              <div class="">
                <a
                  href="monster.html"
                  class="inline-block text-white bg-red-500 hover:bg-red-700 rounded-full px-4 py-2 transition-colors duration-300"
                  >Ajouter à mon deck</a
                >
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Section d'évaluation -->
      @auth
      <div class="mt-6">
        <h3 class="text-2xl font-bold mb-4">Évaluez ce Monstre</h3>
        <div id="rating-section" class="flex items-center text-3xl">
          <span class="rating-star" data-value="1">&#9733;</span>
          <span class="rating-star" data-value="2">&#9733;</span>
          <span class="rating-star" data-value="3">&#9733;</span>
          <span class="rating-star" data-value="4">&#9733;</span>
          <span class="rating-star" data-value="5">&#9733;</span>
        </div>
      </div>
      @endauth
      <script>
        document.addEventListener("DOMContentLoaded", () => {
          const stars = document.querySelectorAll(".rating-star");

          stars.forEach((star) => {
          // Gestionnaire de clic
            star.addEventListener("click", function () {
              let rating = this.getAttribute("data-value");
              updateStars(stars, rating, true); // true indique une sélection permanente
              sendRatingToServer(rating); // Envoyer la notation au serveur
            });

          // Gestionnaire de survol
            star.addEventListener("mouseover", function () {
              let rating = this.getAttribute("data-value");
              updateStars(stars, rating, false); // false indique une mise à jour temporaire
            });

          // Réinitialiser les étoiles lorsque la souris quitte la zone de notation
            star.addEventListener("mouseleave", function () {
              updateStars(stars, getCurrentRating(stars), false);
            });
          });
        });

        function updateStars(stars, rating, isPermanentSelection) {
          stars.forEach((innerStar) => {
            if (innerStar.getAttribute("data-value") <= rating) {
              innerStar.style.color = 'yellow';
            if (isPermanentSelection) {
                innerStar.classList.add("selected");
            }
            } else {
              innerStar.style.color = 'gray'; // Couleur pour les étoiles non sélectionnées
              if (isPermanentSelection) {
                innerStar.classList.remove("selected");
              }
            }
          });
        }

        function getCurrentRating(stars) {
          let rating = 0;
          stars.forEach((star) => {
            if (star.classList.contains('selected')) {
              rating = star.getAttribute("data-value");
            }
          });
          return rating;
        }

        function sendRatingToServer(rating) {
          const url = '/rate-monster';
          const monsterId = {{$monster->id}};
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); 

        // Création de l'objet FormData pour l'envoi
          let formData = new FormData();
          formData.append('rating', rating);
          formData.append('monster_id', monsterId);

          // Requête AJAX pour envoyer la note
          fetch(url, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: formData
          }).then(response => response.json())
          .then(data => {
          // Gérez la réponse ici
          console.log(data);
          })
          .catch(error => {
          console.error('Erreur:', error);
          });
        }
      </script>
    

      <!-- Section commentaires -->
      <div class="mt-6">
        <h3 class="text-2xl font-bold mb-4">Commentaires</h3>
        <div id="commentaires-section">
          <!-- Commentaire -->
          @foreach ($monster->comments as $comment)
          <div class="mb-4 bg-gray-800 rounded p-4">
            <p class="font-bold text-red-400">{{$comment->user->username}}</p>
            <p class="text-sm text-gray-400">{{ $comment->created_at->format('d/m/Y') }}</p>
            <p class="text-gray-300 mt-2">
              {{ $comment->content }}
            </p>
          </div>
          @endforeach
        </div>
        <!-- Formulaire de commentaire -->
        @auth
        <form action="{{ route('monster.comment', $monster->id) }}" method="POST">
            @csrf
            <div class="bg-gray-800 rounded p-4">
              <h4 class="font-bold text-lg text-red-500 mb-2">
                Laissez un commentaire
              </h4>
              <textarea
                name="content" 
                class="w-full p-2 bg-gray-900 rounded text-gray-300"
                rows="4"
                placeholder="Votre commentaire..."
                required
              ></textarea>
              <button type="submit" class="mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full w-full">
                Envoyer
              </button>
            </div>
        </form>
        @endauth
      </div>
    </section>
  </div>
@stop