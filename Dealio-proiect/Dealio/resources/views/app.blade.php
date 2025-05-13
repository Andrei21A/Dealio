<!DOCTYPE html>
<html>

<head>
    @inertia
    @routes
    @vite(['resources/js/app.js']) <!-- Critical: Loads Vue -->
    @inertiaHead

    {{-- Fonts --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poetsen+One&family=Poppins:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">


    
</head>

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    @inertia <!-- Vue mounts here -->
</body>

</html>
