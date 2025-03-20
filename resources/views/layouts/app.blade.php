<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body>
    @if (session('error')) 
        <div>
            {{ session('error') }}
        </div>
    @endif

    <header>
        <h1>Comikit</h1>
        <nav>
            <ul>
                <li>
                    <strong>Browse</strong>
                </li>
                <li>
                    <a href="{{ route('browse.volume.index') }}">Volumes</a>
                </li>
                <li>
                    <a href="{{ route('browse.chapter.index') }}">Chapters</a>
                </li>
                <li>
                    <a href="{{ route('browse.page.index') }}">Pages</a>
                </li>
                <li>
                    <a href="{{ route('browse.page.start') }}">Start</a>
                </li>
                <li>
                    <a href="{{ route('browse.page.latest') }}">Latest</a>
                </li>
            </ul>
            <ul>
                <li>
                    <strong>Admin</strong>
                </li>
                <li>
                    <a href="{{ route('admin.volume.index') }}">Volumes</a>
                </li>
                <li>
                    <a href="{{ route('admin.chapter.index') }}">Chapters</a>
                </li>
                <li>
                    <a href="{{ route('admin.page.index') }}">Pages</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        Welcome, {{ session('patreon.name') }}!
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Comikit
    </footer>

</body>
</html>