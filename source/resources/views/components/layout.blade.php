<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        CodePlay - {{ $title }}
    </title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/codeplay.css', 'resources/js/app.js'])
</head>

<body class="dark:bg-gray-800">
    <x-page.rgbline />
    <x-page.navbar />

    <x-page.title title="{{ $title }}" />
    <x-page.flash />

    {{ $slot }}

    <footer>
    </footer>
</body>

</html>
