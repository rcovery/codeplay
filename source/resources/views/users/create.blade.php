<x-layout title="Register">
    <form method="POST" action="/users">
        @csrf()
        <input type="text" name="username" />
        <input type="text" name="email" />
        <input type="password" name="password" />
        <input type="submit" />
    </form>
    <h1 class="text-3xl font-bold underline">Register</h1>
</x-layout>