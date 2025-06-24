<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Prasthan Yatnam') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-blue: #1e50a2;
            --primary-orange: #ff7f27;
            --light-blue: #5b92e5;
            --dark-blue: #0a2463;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }

        .btn-orange {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            color: white;
        }

        .btn-orange:hover {
            background-color: #e86b00;
            border-color: #e86b00;
            color: white;
        }

        .text-orange {
            color: var(--primary-orange);
        }

        .text-blue {
            color: var(--primary-blue);
        }

        .bg-blue {
            background-color: var(--primary-blue);
        }

        .bg-orange {
            background-color: var(--primary-orange);
        }
    </style>

    @yield('styles')
</head>

<body>
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @yield('scripts')
</body>

</html>