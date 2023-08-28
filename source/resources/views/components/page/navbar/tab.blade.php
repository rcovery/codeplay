<a href="{{ route($link) }}" class="shrink-0 p-3 text-sm font-medium
@if (Request::routeIs($link))
    text-sky-600 dark:border-blue-300 dark:text-sky-300 border-b-2 border-blue-400
@else
    text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200
@endif
">
    {{ $pagename }}
</a>