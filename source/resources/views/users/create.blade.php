<x-layout title="Register">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf()
        <x-form.input type="text" name="username" placeholder="andrewtheguide" :value="old('username')" />
        <x-form.input type="email" name="email" placeholder="yourbest@email.com" :value="old('email')" />
        <x-form.input type="password" name="password" placeholder="*********" :value="old('password')" />
        <x-form.submit />
    </form>
</x-layout>
