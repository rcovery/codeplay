<x-app-layout title="Posts">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>
    <a href="{{ route('posts.create') }}">New Post!</a>

    <div class="flex flex-col gap-4">
        @forelse($posts as $post)
            <div>
                <div class="p-2 flex justify-between">
                    <a href="{{ route('posts.show', $post->id) }}" class="p-6 underline text-gray-900 dark:text-gray-100">
                        {{ $post->title }}
                    </a>
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
                                    <x-danger-button>
                                        {{ __('Delete') }}
                                    </x-danger-button>
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
