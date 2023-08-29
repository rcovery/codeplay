<x-layout title="Login">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-form.input type="text" name="username" placeholder="andrewtheguide" />
        <x-form.input type="password" name="password" placeholder="*********" />

        <x-form.submit />
    </form>
</x-layout>
