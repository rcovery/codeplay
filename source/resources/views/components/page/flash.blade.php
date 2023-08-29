@php
    $flash = session()->get('flash');
@endphp

@isset($flash['message'])
    <p class="bg-blue-400 p-2 m-2 rounded text-sky-950">{{ $flash['message'] }}</p>
@endisset

@isset($flash['error'])
    <p class="bg-red-400 p-2 m-2 rounded text-red-950">{{ $flash['error'] }}</p>
@endisset
