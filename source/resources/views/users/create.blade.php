<x-layout title="Register">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf()
        <x-form.input type="text" name="username" label="Username" />
        <x-form.input type="text" name="email" label="E-Mail" />
        <x-form.input type="password" name="password" label="Password" />
        <x-form.submit />
    </form>
</x-layout>