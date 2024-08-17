<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @if(isset($seo) && isset($seo['meta_title']))
            {{$seo['meta_title']}}
        @else
            Доверие в сети
        @endif
    </title>

    @if(isset($seo) && isset($seo['meta_description']))
    <meta name="description" content="{{$seo['meta_description']}}">
    @endif
    @if(isset($seo) && isset($seo['meta_keywords']))
    <meta name="keywords" content="{{ $seo['meta_keywords'] }}">
    @endif

    <link href="/css/main/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    @yield('style')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  </head>
  <body class="d-flex flex-column min-vh-100">
    <main class="flex-fill">
        <div class="custom-container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <img src="/images/logos/main.png" alt="Logo" class="logo main-logo" />
                    </a>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">

                      <li class="nav-item">

                        <a class="nav-link @if(Route::current()->getName() == 'category') active @endif" href="{{route('category')}}">Статьи</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link @if(Route::current()->getName() == 'top') active @endif" href="{{route('top')}}">Топ 100 сайтов</a>
                      </li>
                    </ul>
                  </div>
                  @guest
    @if (Route::has('login'))
        <a class="btn me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
    @endif

    @if (Route::has('register'))
        <a class="btn" href="{{ route('register') }}">{{ __('Register') }}</a>
    @endif
@else
    <div class="btn-group">
        <a id="navbarDropdown" class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('home')}}">
                {{ __('Profile') }}
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
@endguest

                </div>
              </nav>
              <div>
                @yield('content')
              </div>
        </div>
    </main>
    <footer class="footer bg-dark text-light py-4 mt-5">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center mb-3">
            <img src="/images/logos/main.png" alt="Logo" class="footer-logo mb-2 main-logo" />
            {{-- <a class="text-gray footer-link d-inline-block">
              Мы используем файлы cookies для улучшения работы сайта. Оставаясь
              на нашем сайте, вы соглашаетесь с условиями использования файлов
              cookies. Чтобы ознакомиться с нашими Положениями о
              конфиденциальности и об использовании файлов cookie нажмите на
              этот текст.
            </a> --}}
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-md-4 text-center text-md-left mb-3 mb-md-0">
            <a href="{{route('privacy')}}" class="text-gray footer-link">Политика конфиденциальности</a>
          </div>
          <div class="col-md-4 text-center mb-3 mb-md-0">
            <a href="{{route('terms')}}" class="text-gray footer-link">Пользовательское соглашение</a>
          </div>
          <div class="col-md-4 text-center text-md-right">
            <a href="{{route('contact')}}" class="text-gray footer-link">
              Обратная связь
              <i class="fas fa-up-right-from-square ml-1"></i>
            </a>
          </div>
        </div>
      </div>
    </footer>
    @yield('js')

  </body>
</html>
