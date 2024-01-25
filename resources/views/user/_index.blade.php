    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($users as $user)
            <article class="relative bg-gray-700 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                <div class="p-4">
                    <h3 class="text-xl font-bold">{{ $user->username }}</h3>
                    <p class="text-gray-300 text-sm">{{ $user->email }}</p>
                </div>
                <div class="p-4 text-center">
                    <a href="{{ route('user.show',['id'=> $user->id,'slug' => \Illuminate\Support\Str::slug( $user->username, '-')]) }} "
                        class="inline-block text-white bg-red-500 hover:bg-red-700 rounded-full px-4 py-2 transition-colors duration-300">Plus de détails</a>
                </div>

                @php
                    $isFollowed = auth()->check() && auth()->user()->following->contains($user->id);                
                @endphp

                <div class="absolute top-4 right-4">
                    <button 
                    class="follow-user text-white {{ $isFollowed ? 'bg-red-700' : 'bg-gray-400' }} hover:bg-red-700 rounded-full p-2 transition-colors duration-300"
                        style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;" data-id="{{ $user->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>                 
                    </button>
                </div>
            </article>
        @endforeach
    </div>
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
                            
                          } else if (data.unfollowed) {
                              button.classList.add('bg-gray-400');
                              button.classList.remove('bg-red-500');
                              
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
