<x-layout title="Edit Post">
    <x-posts.form :action="route('posts.update', $post->id)" />
</x-layout>