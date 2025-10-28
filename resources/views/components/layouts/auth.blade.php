<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">
    <div class="w-full min-h-screen flex flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h1 class="text-center text-3xl font-extrabold">
                {{ __('Sign in to your account') }}
            </h1>
            {{ $slot }}
        </div>
    </div>
</body>

</html>
