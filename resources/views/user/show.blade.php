@extends('templates.index')

@section('title')
    Monsters
@stop

@section('content')
<section class="mb-20 relative">
    <div class="max-w-4xl mx-auto bg-gray-700 rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold mb-6 text-center creepster">
            Détails de l'utilisateur
        </h2>
        <div class="mb-8">
            <h3 class="text-xl font-bold mb-2">Nom :</h3>
            <p class="text-gray-300">{{ $user->username }}</p>
        </div>
        <div class="mb-8">
            <h3 class="text-xl font-bold mb-2">E-mail :</h3>
            <p class="text-gray-300">{{ $user->email }}</p>
        </div>
        <div>
            @include('monster._index', ['monsters' => \App\Models\User::find($user->id)->monsters()->orderBy('created_at', 'ASC')->limit(9)->get(),])
        </div>
        <div class="text-center pt-8">
            <a href="{{ route('user.index') }}" class="inline-block text-white bg-red-500 hover:bg-red-700 rounded-full px-6 py-2 transition-colors duration-300 mr-4">Retour à la liste</a>
            <a href="#" class="follow-user inline-block text-white bg-gray-400 hover:bg-red-700 rounded-full px-4 py-2 transition-colors duration-300" data-id="{{ $user->id }}">
                Suivre
            </a>
        </div>

    </div>
</section>
<script>
    document.querySelectorAll('.follow-user').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du bouton
            var userId = this.getAttribute('data-id');
            var url = '{{ route("user.follow", ["userId" => ":id"]) }}'.replace(':id', userId);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ userId: userId })
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                  var buttons = document.querySelectorAll('.follow-user[data-id="' + userId + '"]');
                  buttons.forEach(button => {
                      if (data.followed) {
                          button.classList.remove('bg-gray-400');
                          button.classList.add('bg-red-500');
                          button.textContent = 'Suivi';
                      } else if (data.unfollowed) {
                          button.classList.add('bg-gray-400');
                          button.classList.remove('bg-red-500');
                          button.textContent = 'Suivre';
                      }
                  });
              } else {
                  throw new Error('Échec de l\'action de suivi');
              }
          })
            .catch(error => console.error('Error:', error));
        });
    });
</script>


@stop