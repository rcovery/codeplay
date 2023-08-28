<x-layout title="Posts">
    <a href="{{ route('posts.create') }}">New Post!</a>
    @forelse($posts as $post)
    <h2>#{{ $post->id }} {{ $post->title }}</h2>
    @empty
    <h1>Sem postagens por enquanto!</h1>
    @endforelse
</x-layout>