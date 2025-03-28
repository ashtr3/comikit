<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body>
    @if (session('error')) 
        <div>
            {{ session('error') }}
        </div>
    @endif

    <header>
        <nav>
            <div class="nav-home">
                <a class="link-effect" href="{{ route('home') }}">
                    <span class="sr-only">{{ env('APP_NAME') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M13.885 9.592v-.93q.806-.408 1.726-.612t1.889-.204q.554 0 1.064.071q.509.072 1.052.202v.908q-.524-.167-1.02-.232q-.498-.064-1.096-.064q-.97 0-1.892.218q-.924.218-1.724.643m0 5.462v-.97q.768-.407 1.717-.611t1.899-.204q.554 0 1.064.072q.509.07 1.052.201v.908q-.524-.167-1.02-.232q-.498-.064-1.096-.064q-.97 0-1.892.235q-.924.234-1.724.665m0-2.712v-.969q.806-.408 1.726-.611t1.89-.204q.554 0 1.063.07q.51.072 1.052.203v.908q-.523-.168-1.02-.232q-.497-.065-1.095-.065q-.97 0-1.892.238q-.924.237-1.724.662M12.5 17.32q1.216-.678 2.453-.98t2.547-.3q.9 0 1.618.111t1.267.296q.23.096.423-.029t.192-.394V7.008q0-.173-.096-.308q-.096-.134-.327-.23q-.825-.293-1.501-.4T17.5 5.961q-1.31 0-2.613.386q-1.304.387-2.387 1.16zm-.5 1.45q-1.22-.834-2.62-1.282T6.5 17.04q-.78 0-1.534.13q-.753.131-1.466.42q-.544.217-1.022-.131T2 16.496V6.831q0-.371.195-.689t.547-.442q.887-.383 1.836-.56T6.5 4.962q1.47 0 2.866.423q1.398.423 2.634 1.23q1.237-.807 2.634-1.23t2.866-.423q.973 0 1.922.178q.95.177 1.836.56q.352.125.547.442t.195.689v9.665q0 .614-.516.943q-.517.328-1.1.111q-.693-.27-1.418-.39q-.724-.121-1.466-.121q-1.48 0-2.88.448T12 18.769"/></svg>
                </a>                
            </div>
            <div class="nav-list">
                <ul>
                    <li>
                        <a class="link-effect" href="{{ route('browse.page.start') }}">
                            Start
                        </a>
                    </li>
                    <li>
                        <a class="link-effect" href="{{ route('browse.page.latest') }}">
                            Latest
                        </a>
                    </li>
                    <li>
                        <a class="link-effect" href="{{ route('browse.page.index') }}">
                            Archive
                        </a>
                    </li>
                    @if (session('patreon.is_creator'))
                        <li>
                            <span class="creator">
                                Creator
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M12 6.25a.75.75 0 0 1 .696.471c.354.886.793 1.445 1.24 1.798c.444.353.932.53 1.43.594c1.027.133 2.081-.212 2.732-.499l.017-.007c.093-.041.197-.087.286-.12h.005a1 1 0 0 1 .55-.047a.94.94 0 0 1 .625.474c.124.23.11.462.105.538v.002c-.007.094-.023.204-.036.299c-.262 1.833-.528 3.665-.785 5.498c-.13.92-.619 1.493-1.534 1.758a19.55 19.55 0 0 1-10.662 0c-.915-.265-1.405-.838-1.534-1.758c-.257-1.833-.523-3.665-.785-5.498a4 4 0 0 1-.036-.299v-.002a1 1 0 0 1 .105-.538a.94.94 0 0 1 .625-.474a1 1 0 0 1 .55.046l.004.002c.09.032.194.078.287.119l.017.007c.65.287 1.704.632 2.73.5a2.85 2.85 0 0 0 1.433-.595c.445-.353.884-.912 1.239-1.798A.75.75 0 0 1 12 6.25"/></svg>
                            </span>
                            <menu>
                                <ul>
                                    <li>
                                        <a class="link-effect" href="{{ route('admin.volume.index') }}">
                                            Manage Volumes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="link-effect" href="{{ route('admin.chapter.index') }}">
                                            Manage Chapters
                                        </a>
                                    </li>
                                    <li>
                                        <a class="link-effect" href="{{ route('admin.page.index') }}">
                                            Manage Pages
                                        </a>
                                    </li>
                                </ul>
                            </menu>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="nav-user">
                @if (empty(session('patreon')))
                    <a href="{{ route('auth.redirect') }}" class="nav-user-login-btn">
                        <span class="hover-only">Login with Patreon</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M7.462 3.1c2.615-1.268 6.226-1.446 9.063-.503c2.568.853 4.471 3.175 4.475 5.81c.004 3.061-1.942 5.492-4.896 6.243c-1.693.43-2.338.75-2.942 1.582c-.238.328-.45.745-.796 1.533l-.22.5C11 20.866 9.99 22.027 7.91 22c-2.232-.03-3.603-1.742-4.313-4.48c-.458-1.768-.617-3.808-.594-5.876c.044-3.993 1.42-7.072 4.46-8.545z"/></svg>
                    </a>
                @else
                    <div class="nav-user-identity">
                        <span class="nav-user-name hover-only">{{ session('patreon.name') }}</span>
                        <img class="nav-user-avatar" src="{{ session('patreon.avatar') }}" alt="{{ session('patreon.name') }}'s avatar">
                    </div>                        
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-user-logout-btn">
                            <span class="hover-only">Disconnect Patreon</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 5l3-3M2 22l3-3m1.3 1.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6l-2.3 2.3a2.4 2.4 0 0 0 0 3.4Zm1.2-6.8L10 11m.5 5.5L13 14m-1-8l6 6l2.3-2.3a2.4 2.4 0 0 0 0-3.4l-2.6-2.6a2.4 2.4 0 0 0-3.4 0Z"/></svg>
                        </button>
                    </form>    
                @endif
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Comikit
    </footer>

</body>
</html>