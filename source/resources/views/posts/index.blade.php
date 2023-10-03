<x-app-layout title="Posts">
    <a href="{{ route('posts.create') }}">New Post!</a>

    <div class="flex flex-col gap-4">
        @forelse($posts as $post)
            <div>
                <div class="p-2 flex justify-between">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $post->title }}
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $post->content }}
                    </div>

                    @if (Auth::id() == $post->user_id)
                        <div class="flex">
                            <a href="{{ route('posts.edit', $post->id) }}">
                                <x-primary-button>
                                    {{ __('Edit') }}
                                </x-primary-button>
                            </a>
                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <x-primary-button>
                                        {{ __('Edit') }}
                                    </x-primary-button>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <h1>Sem postagens por enquanto!</h1>
        @endforelse
    </div>
</x-app-layout>
