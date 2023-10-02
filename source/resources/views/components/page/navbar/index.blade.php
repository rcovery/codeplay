<nav class="flex justify-between items-center w-full">
    <a href="{{ route('home') }}">
        <img class="w-12 ml-2 mt-2" title="Logo" alt="Logo" src="/logo.png" />
    </a>

    <div class="container ml-4">
        <div class="-mb-px flex gap-2">
            <x-page.navbar.tab pagename="Home" link="home" />
            <x-page.navbar.tab pagename="Posts" link="posts.index" />
        </div>
    </div>

    <div class="mr-4">
        @auth
            <x-page.navbar.tab pagename="Logout" link="logout" />
        @endauth

        @guest
            <x-page.navbar.tab pagename="Login" link="login" />
        @endguest
    </div>
</nav>
