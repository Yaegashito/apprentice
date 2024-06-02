<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <!-- Styles -->
</head>
<body class="antialiased">
<nav class="navbar navbar-light">
<div class="container">
    <a class="navbar-brand" href="/">conduit</a>
    <ul class="nav navbar-nav pull-xs-right">
        @if (Route::has('login'))
            @auth
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/dashboard') }}" class="">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/editor"> <i class="ion-compose"></i>&nbsp;New Article </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/settings"> <i class="ion-gear-a"></i>&nbsp;Settings </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile/eric-simons">
                    <img src="" class="user-pic" />
                        {{ Auth::user()->name; }}
                    </a>
                </li>
                <li class="nav-item">
                    <form class="nav-link" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>

            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}" class="">Sing in</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" class="">Sign up</a>
                    </li>
                @endif
            @endauth
        @endif
    </ul>
</div>
</nav>

{{ $slot }}

<footer>
  <div class="container">
    <a href="/" class="logo-font">conduit</a>
    <span class="attribution">
      An interactive learning project from <a href="https://thinkster.io">Thinkster</a>. Code &amp;
      design licensed under MIT.
    </span>
  </div>
</footer></body>
</html>
