@php
    $post = request('post');
@endphp

<form method="POST" action="{{ $action }}">
    @csrf()

    @isset($post->id)
        @method('PUT')
    @endisset

    <input hidden name="user_id" value={{ Auth::id() }} />
    <x-form.input type="text" name="title" placeholder="Title" :value="$post->title ?? ''" />
    <x-form.input type="text" name="content" placeholder="Content" :value="$post->content ?? ''" />
    <x-form.submit />
</form>
