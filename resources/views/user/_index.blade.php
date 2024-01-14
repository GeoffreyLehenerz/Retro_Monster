<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($users as $user)
    <article class="relative bg-gray-700 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
        <div class="p-4">
            <h3 class="text-xl font-bold">{{ $user->username }}</h3>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($user->monsters as $monster)
                    <li>
                        <a href="{{ route('monsters.show',['id'=> $monster->id,'slug' => \Illuminate\Support\Str::slug( $monster->name, '-')]) }}" class="text-red-400 hover:text-red-600">
                            {{ $monster->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </article>
    @endforeach
</div>