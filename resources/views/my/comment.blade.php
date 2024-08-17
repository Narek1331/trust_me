@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <!-- Profile Comments Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <a href="{{ route('home') }}" class="text-white">
                        {{ __('Profile') }}
                    </a>
                    > {{ __('My Comments') }}
                </div>

                <div class="card-body">
                    @foreach ($comments as $comment)
                        <div class="card mb-4 border-primary rounded">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <svg width="40" height="40" viewBox="0 0 36 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M35.4776 18.2514C35.1333 20.1033 34.6342 21.8073 34.0253 23.371C32.6279 26.9881 30.6716 29.8527 28.7702 32.0209C24.0589 37.3879 18.7988 39.6607 18.5767 39.7551L18.0003 40L17.4238 39.7551C17.2017 39.6607 11.9391 37.3879 7.22787 32.0209C5.85543 30.4572 4.45305 28.5262 3.25529 26.2101C2.95335 25.631 2.66639 25.029 2.3944 24.404H5.69573C6.68389 26.3708 7.93904 28.2252 9.46619 29.9675C12.8549 33.8295 16.5879 35.9314 17.9928 36.638C19.4151 35.9212 23.2105 33.7785 26.6042 29.8782C28.845 27.3018 30.4969 24.4755 31.5599 21.4093C31.5699 21.3838 31.5774 21.3558 31.5899 21.3277H27.1257V18.2514H35.4776Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive')green @else yellow @endif"></path>
                                            <path d="M35.8894 15.1751H32.8875C33.1196 12.5579 32.9973 9.8004 32.5107 6.91283L17.9978 3.17327L3.48744 6.91028C2.84115 10.7468 2.83366 14.3537 3.45749 17.7081C3.46498 17.7336 3.46997 17.7616 3.47247 17.7897C3.49991 17.9427 3.52986 18.0958 3.5623 18.2488H8.86739V21.3252H1.27158C0.992097 20.4043 0.752545 19.4375 0.557908 18.4274C-0.165741 14.6827 -0.255573 10.3412 0.707629 5.35935L0.892284 4.40533L17.9978 0L35.1059 4.40533L35.2906 5.35935C35.9893 8.96117 36.134 12.2263 35.8894 15.1751Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive')green @else yellow @endif"></path>
                                            <path d="M35.4776 18.2514C35.1333 20.1033 34.6342 21.8073 34.0253 23.371C32.6279 26.9881 30.6716 29.8527 28.7702 32.0209C24.0589 37.3879 18.7988 39.6607 18.5767 39.7551L18.0003 40L17.4238 39.7551C17.2017 39.6607 11.9391 37.3879 7.22787 32.0209C5.85543 30.4572 4.45305 28.5262 3.25529 26.2101C2.95335 25.631 2.66639 25.029 2.3944 24.404H5.69573C6.68389 26.3708 7.93904 28.2252 9.46619 29.9675C12.8549 33.8295 16.5879 35.9314 17.9928 36.638C19.4151 35.9212 23.2105 33.7785 26.6042 29.8782C28.845 27.3018 30.4969 24.4755 31.5599 21.4093C31.5699 21.3838 31.5774 21.3558 31.5899 21.3277H27.1257V18.2514H35.4776Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive')green @else yellow @endif"></path>
                                            <path d="M35.8894 15.1751H32.8875C33.1196 12.5579 32.9973 9.8004 32.5107 6.91283L17.9978 3.17327L3.48744 6.91028C2.84115 10.7468 2.83366 14.3537 3.45749 17.7081C3.46498 17.7336 3.46997 17.7616 3.47247 17.7897C3.49991 17.9427 3.52986 18.0958 3.5623 18.2488H8.86739V21.3252H1.27158C0.992097 20.4043 0.752545 19.4375 0.557908 18.4274C-0.165741 14.6827 -0.255573 10.3412 0.707629 5.35935L0.892284 4.40533L17.9978 0L35.1059 4.40533L35.2906 5.35935C35.9893 8.96117 36.134 12.2263 35.8894 15.1751Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive')green @else yellow @endif"></path>
                                            <path d="M18 10L20.4452 14.6345L25.6085 15.5279L21.9564 19.2855L22.7023 24.4721L18 22.16L13.2977 24.4721L14.0436 19.2855L10.3915 15.5279L15.5548 14.6345L18 10Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive')green @else yellow @endif"></path>
                                        </svg>
                                    </div>
                                    <div class="ms-2">
                                        <strong>{{ $comment->reviewType->name }} отзыв</strong>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong>{{ $comment->search }}</strong>
                                    </div>
                                    <div class="text-muted">
                                        {{ $comment->created_at->format('d M Y, H:i') }}
                                    </div>
                                    <div>
                                        <a href="/user/257936" class="text-decoration-none">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16 3C8.83203 3 3 8.83203 3 16C3 23.168 8.83203 29 16 29C23.168 29 29 23.168 29 16C29 8.83203 23.168 3 16 3ZM16 5C22.0859 5 27 9.91406 27 16C27 22.0859 22.0859 27 16 27C9.91406 27 5 22.0859 5 16C5 9.91406 9.91406 5 16 5ZM16 8C13.25 8 11 10.25 11 13C11 14.5156 11.707 15.8633 12.7812 16.7812C10.5312 17.9492 9 20.3008 9 23H11C11 20.2266 13.2266 18 16 18C18.7734 18 21 20.2266 21 23H23C23 20.3008 21.4688 17.9492 19.2188 16.7812C20.293 15.8633 21 14.5156 21 13C21 10.25 18.75 8 16 8ZM16 10C17.668 10 19 11.332 19 13C19 14.668 17.668 16 16 16C14.332 16 13 14.668 13 13C13 11.332 14.332 10 16 10Z" fill="currentColor"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <p class="mt-3 mb-0">{{ $comment->text }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
