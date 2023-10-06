    @php
        $post = request('post');
        $comments = $post
            ->comments()
            ->with('user')
            ->get();
    @endphp

    <div class="flex flex-col gap-4">
        @auth
            <div class="pt-5">
                <form method="POST" action="{{ route('comments.store', ['post' => $post->id]) }}">
                    @csrf
                    <x-input-label for="new_comment" value="New comment" />
                    <x-textarea-input class="w-full" name="content" id="new_comment"
                        placeholder="Write something interesting!" />
                    <x-primary-button>{{ __('Comment') }}</x-primary-button>
                </form>
            </div>
        @endauth

        <div class="p-6 flex gap-4 flex-col">
            @forelse($comments as $comment)
                <div class="flex justify-between">
                    <div class="p-1 text-gray-900 dark:text-gray-100">
                        <small>
                            {{ $comment->user->name }} says:
                        </small>
                        <div class="pl-2">
                            {{ $comment->content }}
                        </div>
                    </div>

                    @if (Auth::id() == $comment->user_id)
                        <div class="flex">
                            <a href="{{ route('posts.edit', $comment->id) }}">
                                <x-primary-button>
                                    {{ __('Edit') }}
                                </x-primary-button>
                            </a>
                            <form method="POST" action="{{ route('posts.destroy', $comment->id) }}">
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
            @empty
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    No comments for the moment!
                </div>
            @endforelse
        </div>
    </div>
