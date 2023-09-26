<div>
    @isset($label)
    <label for="input-{{ $name }}" class="text-purple-900 dark:text-purple-200">
        {{ $label }}:&nbsp;
    </label>
    @endisset

    <input type="{{ $type }}" id="input-{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" @isset($value) value="{{ $value }}" @endisset class="rounded bg-purple-200 dark:bg-gray-700 p-2 outline-0 text-purple-900 dark:text-purple-200 w-full" />
</div>