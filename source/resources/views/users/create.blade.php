<x-layout title="Register">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf()
        <x-form.input type="text" name="username" />
        <x-form.input type="text" name="email" />
        <x-form.input type="password" name="password" />
        <x-form.submit />
    </form>
</x-layout>