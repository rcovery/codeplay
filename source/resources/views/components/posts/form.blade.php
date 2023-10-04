@php
    $post = request('post');
@endphp

<form method="POST" action="{{ $action }}">
    @csrf()

    @isset($post->id)
        @method('PUT')
    @endisset

    <input hidden name="user_id" value={{ Auth::id() }} />
    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input type="text" name="title" placeholder="Title" :value="$post->title ?? ''" />
    </div>
    <div>
        <x-input-label for="content" :value="__('Content')" />
        <x-text-input type="text" name="content" placeholder="Content" :value="$post->content ?? ''" />
    </div>

    <x-primary-button>{{ __('Save') }}</x-primary-button>
</form>
