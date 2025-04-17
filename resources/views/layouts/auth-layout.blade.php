<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marck+Script&display=swap" rel="stylesheet">
    <title>@yield('title', 'Sitani')</title>
</head>

<body class="w-screen h-screen max-w-screen max-h-screen">
    <div class="root-container w-full h-full flex justify-center items-center bg-[#F5F7FF]">
        @yield('content')
    </div>
</body>

</html>
