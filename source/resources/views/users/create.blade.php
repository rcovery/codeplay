<x-layout title="Register">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf()
        <x-form.input type="text" name="username" placeholder="andrewtheguide" label="Username" />
        <x-form.input type="text" name="email" placeholder="andrewtheguide@terraria.com" label="E-Mail" />
        <x-form.input type="password" name="password" placeholder="**********" label="Password" />
        <x-form.submit />
    </form>
</x-layout>
