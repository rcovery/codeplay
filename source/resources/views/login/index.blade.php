<x-layout title="Login">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-form.input type="text" name="username" placeholder="andrewtheguide" />
        <x-form.input type="password" name="password" placeholder="*********" />

        <x-form.submit />
    </form>

    <a href="{{ route('users.create') }}" class="dark:text-purple-200 text-gray-900">Don't have a user? Create one!</a>
</x-layout>
