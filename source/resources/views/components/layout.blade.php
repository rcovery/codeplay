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

    <div class="w-full sm:w-6/12 m-auto">
        <x-page.flash />

        {{ $slot }}
    </div>

    <footer>
    </footer>
</body>

</html>
