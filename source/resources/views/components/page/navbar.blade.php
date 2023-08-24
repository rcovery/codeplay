<!-- TODO fazer uma navbar melhor -->

<nav class="flex justify-between items-center w-full">
    <a href="/">
        <img class="w-12 ml-2 mt-2" title="Logo" alt="Logo" src="/logo.png" />
    </a>

    <div class="container ml-4">
        <div class="-mb-px flex gap-2">
            <a href="#" class="shrink-0 border-b-2 border-blue-400 p-3 text-sm font-medium text-sky-600 dark:border-blue-300 dark:text-sky-300">
                Home
            </a>

            <a href="#" class="shrink-0 p-3 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                Games
            </a>
        </div>
    </div>

    <div class="mr-4 mt-2">
        <a href="/login" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Login</a>
        <div class="nav_menu_button" onclick="dropdown()">
            <span class="dropdown_bar"></span>
            <span class="dropdown_bar"></span>
            <span class="dropdown_bar"></span>
        </div>
    </div>
</nav>