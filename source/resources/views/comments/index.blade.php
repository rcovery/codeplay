    @php
        $post = request('post');
        $comments = $post
            ->comments()
            ->with('user')
            ->with('replies')
            ->where('comment_id', null)
            ->get();
    @endphp

    {{-- Improve this section! --}}

    <div class="flex flex-col gap-4">
        @auth
            <div class="pt-5">
                <form method="POST" action="{{ route('comments.store', ['post' => $post->id]) }}">
                    @csrf
                    <x-input-label for="new_comment" value="New comment" />
                    <x-textarea-input rows=4 required class="w-full" name="content" id="new_comment"
                        placeholder="Write something interesting!" />
                    <x-primary-button>{{ __('Comment') }}</x-primary-button>
                </form>
            </div>
        @endauth

        <div class="flex gap-4 flex-col">
            @forelse($comments as $comment)
                <div class="bg-slate-200 dark:bg-slate-700 p-3 rounded-md relative">
                    <div class="p-1 text-gray-800 dark:text-gray-200">
                        <small>
                            {{ $comment->user->name }} says:
                        </small>
                        <div class="pl-2">
                            {{ $comment->content }}
                        </div>

                        <div class="p-2">
                            <form method="POST"
                                action="{{ route('replies.store', ['post' => $post->id, 'comment' => $comment->id]) }}">
                                @csrf
                                <x-textarea-input rows="2" required class="w-full" name="content"
                                    id="reply_comment_{{ $comment->id }}" placeholder="Reply something interesting!" />
                                <x-primary-button>{{ __('Reply') }}</x-primary-button>
                            </form>

                            <div class="flex flex-col gap-4">
                                @forelse($comment->replies as $reply)
                                    <div>
                                        <small>
                                            {{ $reply->user->name }} replied:
                                        </small>
                                        <div class="pl-2">
                                            {{ $reply->content }}
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="absolute right-3 top-3">
                        @if (Auth::id() == $comment->user_id)
                            {{-- <a href="{{ route('posts.edit', $comment->id) }}">
                                <x-primary-button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </x-primary-button>
                            </a> --}}
                            <form method="POST" action="{{ route('posts.destroy', $comment->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <svg class="text-red-600" xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trash-2">
                                        <path d="M3 6h18" />
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        <line x1="10" x2="10" y1="11" y2="17" />
                                        <line x1="14" x2="14" y1="11" y2="17" />
                                    </svg>

                                </button>
                            </form>
                        @else
                            Test Like
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    No comments for the moment!
                </div>
            @endforelse
        </div>
    </div>
