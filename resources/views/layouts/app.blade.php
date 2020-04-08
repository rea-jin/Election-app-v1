<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <h1>みんなの投票所</h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto ml-1 mb-1 font-bold">
                        <li class="nav-item float-left">
                            <a href="{{ url('/elections/new') }}" class="nav-link shadow-sm p-3 mb-auto bg-white rounded">選挙作成</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-auto ml-1 mb-1 font-bold">
                        <li class="nav-item float-left">
                            <a href="{{ route('elections.mypage') }}" class="nav-link shadow-sm p-3 mb-auto bg-white rounded">マイページ</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    {{-- <ul class="navbar-nav ml-auto"> --}}
                        <!-- Authentication Links -->
                        @guest
                        <ul class="navbar-nav mr-auto ml-1 mb-1 font-bold">
                            <li class="nav-item float-left">
                                <a href="{{ route('login') }}" class="nav-link shadow-sm p-3 mb-auto bg-white rounded">{{ __('Login') }}</a>
                            </li>
                        </ul>

                            @if (Route::has('register'))
                            <ul class="navbar-nav mr-auto ml-1 mb-1 font-bold">
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link shadow-sm p-3 mb-auto bg-white rounded">{{ __('ユーザー登録') }}</a>
                                </li>
                            </ul>
                            @endif
                        @else
                        {{--  --}}
                        <ul class="navbar-nav mr-auto ml-1 mb-1 font-bold">
                            <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link shadow-sm p-3 mb-auto bg-white rounded" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</a>
                        </li>
                        {{-- <li class="nav-item float-left"> --}}
                            {{-- <a href="{{ url('/elections/new') }}" class="nav-link">選挙作成</a> --}}
                            {{-- <a href="{{ route('elections.contact') }}" class="nav-link">退会する</a> --}}
                            {{-- <a class="nav-link" href="{{ route('elections.duser') }}" onclick="event.preventDefault(); document.getElementById('delete-user').submit();">{{ __('退会する') }}</a> --}}
                            
                            <a href="{{ route('elections.duser')}}" class="nav-link"  role="button"  onclick="event.preventDefault(); document.getElementById('delete-user').submit();">
                                ユーザー：{{ Auth::user()->name }}
                                <div class="btn btn-warning" onclick='return confirm("退会しますか？");'>{{ __('退会する')  }}</div>
                             </a>
                            {{-- </li> --}}
                        </ul>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <form id="delete-user" action="{{ route('elections') }}" method="post" class="d-inline" style="display:none;">
                                        @csrf
                                        {{ method_field('delete') }}
                                    </form>
                                    {{-- <form id="delete-user" action="{{ route('elections.duser') }}" method="post" class="d-inline">
                                        @csrf
                                        <button class="btn" onclick='return confirm("退会しますか？");'>{{ __('退会する')  }}</button>
                                    </form> --}}
                        @endguest
                    {{-- </ul> --}}
                </div>
            </div>
        </nav>

        @if (session('flash_message')) 
        <div class="alert alert-primary text-center fixed-top" role="alert">
            {{ session('flash_message') }}
        </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>

    </div>

    @section('footer')
    <footer>
        @if(Request::is('elections/contact'))
            <div class="text-center mt-3 mb-3" style=""></div>
        @else
        <div>
            <a href="{{ route('elections.contact') }}" class="nav-link mt-3 mb-3 p-5 text-center">{{ __('問い合わせはこちら') }}</a>
            {{-- <a href="#>"  --}}
            </div>
            @endif
    </footer>

    <!-- <script src="{{ asset('/js/jquery-3.1.1.min.js') }}"></script> -->
    <script
          src="https://code.jquery.com/jquery-3.2.1.min.js"
          integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
          crossorigin="anonymous"></script>
    @show
</body>
</html>
