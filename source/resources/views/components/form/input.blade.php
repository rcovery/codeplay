<input type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}"
    @isset($value) value="{{ $value }}" @endisset
    class="rounded bg-gray-200 dark:bg-gray-700 p-2 outline-0 text-purple-900 dark:text-purple-200" />
