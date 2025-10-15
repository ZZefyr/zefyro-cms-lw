<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin panel' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    @vite([
           'core/Resources/assets/css/tailwind.css',
           'core/Resources/assets/css/app.scss',
           'core/Resources/assets/js/app.js'
       ])
</head>
<body class="bg-gray-50 min-h-screen">
<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
        <div class="h-full flex flex-col">
            <!-- Logo/Brand -->
            <div class="h-16 flex flex-col items-center justify-center border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                <h1 class="text-xl font-bold text-white">[ZD] Zefyro Digital</h1> <small class="text-white">Verze: 0.0.1</small>
            </div>

            <!-- Menu -->
            <nav class="flex-1 overflow-y-auto py-4">
                <livewire:core::admin.components.menu />
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        {{ $slot }}
    </div>
</div>
</body>
</html>
