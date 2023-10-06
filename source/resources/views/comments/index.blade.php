    <div class="flex flex-col gap-4">
        @forelse($comments as $comments)
            <div>
                <div class="p-2 flex justify-between">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $comments->content }}
                    </div>

                    @if (Auth::id() == $comments->user_id)
                        <div class="flex">
                            <a href="{{ route('posts.edit', $comments->id) }}">
                                <x-primary-button>
                                    {{ __('Edit') }}
                                </x-primary-button>
                            </a>
                            <form method="POST" action="{{ route('posts.destroy', $comments->id) }}">
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
            <div class="p-6 text-gray-900 dark:text-gray-100">
                Sem comentários por enquanto!
            </div>
        @endforelse

        <div>
            <x-input-label for="new_comment" value="New comment" />
            <x-text-input class="w-full" id="new_comment" placeholder="Write something interesting!" />
        </div>
    </div>
