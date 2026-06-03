<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStock</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#f8f9ff]">

    @include('partials.sidebar')

    <main class="ml-[280px] min-h-screen">

        @include('partials.topbar')

        <div class="mt-16 p-8 max-w-7xl mx-auto">

            @yield('content')

        </div>

    </main>

    @yield('scripts')

</body>
</html>