<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" href="{{ asset('assets/imagenes/logo_metaluna_original.png') }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

        <!-- Fonts-->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="bg-gray-200">
        <livewire:pages.layout.navbar />
        <livewire:pages.layout.drawer />

        <div class="lg:ml-64 lg:pl-4 lg:flex lg:flex-col lg:w-75% mt-5 mx-2">
            {{ $slot }}
        </div>

        <script>
            // Agregar lógica para mostrar/ocultar la navegación lateral al hacer clic en el ícono de menú
            const menuBtn = document.getElementById('menuBtn');
            const sideNav = document.getElementById('sideNav');

            menuBtn.addEventListener('click', () => {
                sideNav.classList.toggle('hidden');
            });
        </script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    </body>

</html>


