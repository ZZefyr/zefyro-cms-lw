<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
</head>
<body>
<header>
    <h1>Administrace</h1>
    <nav>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Odhlásit</button>
        </form>
    </nav>
</header>

<main>
    @yield('content')
</main>
</body>
</html>
