<x-app-layout title="Posts">
    <x-slot name="title">
        {{ $post->title }}
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $post->title }}
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $post->content }}
                    </div>
                </div>
                <hr>
                <div class="flex">
                    <div class="w-3/4">
                        @include('comments.index')
                    </div>
                    <div class="w-1/4">
                        {{-- Include Related Posts  --}}
                        Related Posts
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
