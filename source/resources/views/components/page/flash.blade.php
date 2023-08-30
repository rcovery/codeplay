@php
    $flash = session()->get('flash');
@endphp

@isset($flash['message'])
    <p class="bg-blue-400 p-2 m-2 rounded text-sky-950">{{ $flash['message'] }}</p>
@endisset

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p class="bg-red-400 p-2 m-2 rounded text-red-950">{{ $error }}</p>
    @endforeach
@endif
