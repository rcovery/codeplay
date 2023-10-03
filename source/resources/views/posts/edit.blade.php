<x-app-layout title="Edit Post">
    <x-posts.form :action="route('posts.update', $post->id)" />
</x-app-layout>
