<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @yield('head')

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="/css/main/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    @yield('style')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  </head>
  <body class="d-flex flex-column min-vh-100">
    @include('partials.notification_modal')

    <main class="flex-fill">
        <div class="custom-container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <img src="{{logoPath()}}" alt="Logo" class="logo main-logo" />
                    </a>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">

                      <li class="nav-item">

                        <a class="nav-link @if(Route::current()->getName() == 'category') active @endif" href="{{route('category')}}">Статьи</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link @if(Route::current()->getName() == 'top') active @endif" href="{{route('top')}}">Топ 100 сайтов</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link @if(Route::current()->getName() == 'search.latest') active @endif" href="{{route('search.latest')}}">Последние проверки</a>
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
        {{-- ads --}}
        @if (isset($adCategories) && $topAds = $adCategories->where('slug','top')->first())
        @if(!empty($topAds->ads))
        @php
            $chunkedAds = $topAds->ads->chunk(3);
        @endphp


        <div class="ads_section_1 mt-4">
            <div id="main_slider_1" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($chunkedAds as $index => $adsChunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    @foreach ($adsChunk as $ad)
                                        <div class="col">
                                            <div class="card bg-white h-100 d-flex flex-column" style="width: {{$topAds->width}}px; height: {{$topAds->height}}px;">
                                                @if ($ad->img_path)
                                                    <img src="/storage/{{ $ad->img_path }}" class="card-img-top" alt="{{ $ad->title }}" style="object-fit: cover; height: calc({{$topAds->height}}px - 40px);">
                                                @endif
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title text-gold-no-hover">{{ $ad->title }}</h5>
                                                    <p class="card-text text-truncate text-gold-no-hover flex-grow-1">{{ $ad->description }}</p>
                                                    <a href="{{$ad->link}}" target="_blank" class="btn text-gold-no-hover mt-auto">Узнать больше</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @endif
        @endif

    {{-- ads --}}

        {{-- ads --}}
        @if (isset($adCategories) && $bottomAds = $adCategories->where('slug','bottom')->first())
        @if(!empty($bottomAds->ads))
        @php
            $chunkedAds = $bottomAds->ads->chunk(3);
        @endphp


        <div class="ads_section_2 mt-4">
            <div id="main_slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($chunkedAds as $index => $adsChunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    @foreach ($adsChunk as $ad)
                                        <div class="col">
                                            <div class="card bg-white h-100 d-flex flex-column" style="width: {{$bottomAds->width}}px; height: {{$bottomAds->height}}px;">
                                                @if ($ad->img_path)
                                                    <img src="/storage/{{ $ad->img_path }}" class="card-img-top" alt="{{ $ad->title }}" style="object-fit: cover; height: calc({{$bottomAds->height}}px - 40px);">
                                                @endif
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title text-gold-no-hover">{{ $ad->title }}</h5>
                                                    <p class="card-text text-truncate text-gold-no-hover flex-grow-1">{{ $ad->description }}</p>
                                                    <a href="{{$ad->link}}" target="_blank" class="btn text-gold-no-hover mt-auto">Узнать больше</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Controls -->
                {{-- <button class="carousel-control-prev" type="button" data-bs-target="#main_slider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#main_slider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button> --}}
            </div>
        </div>

        @endif
        @endif

        {{-- ads --}}
    </main>
    <footer class="footer bg-dark text-light py-4 mt-5">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center mb-3">
            <img src="{{logoPath()}}" alt="Logo" class="footer-logo mb-2 main-logo" />
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
  </body>
</html>
