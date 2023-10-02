<x-layout title="Login">
    <form method="POST" action="{{ route('auth.login') }}">
        @csrf

        <div class="flex flex-col justify-center content-center">
            <x-form.input type="text" name="username" placeholder="andrewtheguide" label="E-Mail" />
            <x-form.input type="password" name="password" placeholder="*********" label="Password" />

            <x-form.submit />
        </div>
    </form>

    <p>Don't have a login? <a href="{{ route('auth.register') }}">Register here!</a></p>
</x-layout>
