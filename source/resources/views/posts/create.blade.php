<x-layout title="Create Post">
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf()
        <input hidden name="user_id" value=1 />
        <x-form.input type="text" name="title" placeholder="Title" />
        <x-form.input type="text" name="content" placeholder="Content" />
        <x-form.submit />
    </form>
</x-layout>