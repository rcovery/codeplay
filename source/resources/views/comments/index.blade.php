    @php
        $post = request('post');
        $comments = $post->comments();
    @endphp

    <div class="flex flex-col gap-4">
        <div class="pt-5">
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <x-input-label for="new_comment" value="New comment" />
                <x-textarea-input class="w-full" name="content" id="new_comment"
                    placeholder="Write something interesting!" />
                <x-primary-button>{{ __('Comment') }}</x-primary-button>
            </form>
        </div>

        @forelse($comments as $comment)
            <div>
                <div class="p-2 flex justify-between">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $comment->content }}
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
            </div>
        @empty
            <div class="p-6 text-gray-900 dark:text-gray-100">
                No comments for the moment!
            </div>
        @endforelse
    </div>
