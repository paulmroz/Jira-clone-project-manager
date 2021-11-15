<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div id="app">
    <nav class="bg-white">
        <div class="container mx-auto">
            <div class="flex justify-between items-center py-2">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>

                <div>
                    <!-- Right Side Of Navbar -->
                    <ul class="flex">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="mr-12">
                                    <a class="nav-link" href="{{ route('login') }}">Zaloguj się</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li >
                                    <a class="nav-link" href="{{ route('register') }}">Zarejestruj się</a>
                                </li>
                            @endif
                        @else
                            <div class="bg-white flex flex-col justify-center">
                                <div class="flex items-center justify-center">
                                    <div class="relative inline-block text-left dropdown">
                                        <span class="rounded-md shadow-sm"
                                        ><button class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
                                                 type="button" aria-haspopup="true" aria-expanded="true" aria-controls="headlessui-menu-items-117">
                                            <span>Moje Konto</span>
                                            <svg class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button
                                            ></span>
                                        <div class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                                            <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                                                <div class="px-4 py-3">
                                                    <p class="text-sm leading-5">Zalogowany jako</p>
                                                    <p class="text-sm font-medium leading-5 text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                                </div>
                                                <div class="py-1">
                                                    <a href="/projects" tabindex="0" class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"  role="menuitem" >Projekty</a>
                                                    @can('edit', auth()->user())
                                                        <a href="{{auth()->user()->path('edit')}}" tabindex="1" class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"  role="menuitem">Ustawienia</a>
                                                    @endcan
                                                </div>
                                                <div class="py-1">
                                                    <a tabindex="3" href="{{ route('logout') }}"
                                                       class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"  role="menuitem"
                                                       onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                                                        {{ __('Wyloguj') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img class="inline object-cover w-8 h-8 rounded-full ml-3" src="{{auth()->user()->avatar}}" alt="Profile image"/>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
