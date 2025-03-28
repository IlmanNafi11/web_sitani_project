<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login | Sitani</title>
</head>

<body class="max-w-screen max-h-screen">
    <div class="layout mx-auto md:w-full md:min-h-screen md:h-auto md:mx-0 bg-[#F9FAFB]">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
