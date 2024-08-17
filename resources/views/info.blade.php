<?php

// Initialize counters for positive and negative ratings and comments
$positiveRatingsCount = 0;
$negativeRatingsCount = 0;
$neutralRatingsCount = 0;
$positiveCommentsCount = 0;
$negativeCommentsCount = 0;
$neutralCommentsCount = 0;
// Process each rating type
foreach ($ratingTypes as $ratingType) {
    $commentsForType = $comments;

    // Count comments based on rating type
    if ($ratingType->slug === 'positive') {
        $positiveCommentsCount += $commentsForType->where('review_type_id', $ratingType->id)->count();

        $positiveRatingsCount += $commentsForType->flatMap(function ($comment) {
            return $comment->positiveRates;
        })->count();
    } elseif ($ratingType->slug === 'negative') {
        $negativeCommentsCount += $commentsForType->where('review_type_id', $ratingType->id)->count();

        $negativeRatingsCount += $commentsForType->flatMap(function ($comment) {
            return $comment->negativeRates;
        })->count();
    }elseif ($ratingType->slug === 'neutral') {
        $neutralCommentsCount += $commentsForType->where('review_type_id', $ratingType->id)->count();
    }
}

?>

@extends('layouts.app')
@section('content')
<div class="container my-4">
    <div class="text-center mb-4">
        <h1 class="mt-3">Проверка и отзывы о {{$check->name}} {{$q}}</h1>
    </div>

    @if($check && ($check->slug == 'site' || $check->parentCheck && $check->parentCheck->slug == 'site'))

    @if(empty($additionalInfo))
    <div class="card mb-4 bg-white">
        <div class="card-body">
          <div class="">
            <form action="{{route('info.store')}}" method="POST">
                @csrf
                <input type="text" name="search" hidden value="{{request()->q}}">
            <button type="submit" class="btn btn-primary">Запросить больше информации у администратора</button>
            </form>
        </div>
        </div>
    </div>
    @endif

    <div class="card mb-4 bg-white">
        <div class="card-body">
          <div class="mb-3">
            <span>
              Вы можете ознакомиться с отзывами о сайте
              <a href="@if($check->url){{$check->url}}/@endif{{$q}}" class="link-primary">
                @if($check->url){{$check->url}}/@endif{{$q}}
            </a>
            </span>
          </div>
          Мы тщательно проверяем все комментарии и оценки пользователей
          <div class="d-flex flex-column">
            @foreach ($ratingTypes as $ratingType)
                <div class="mb-2">
                    <span class="@if($ratingType['slug'] == 'positive') text-success @elseif($ratingType['slug'] == 'negative')) text-danger @else text-warning  @endif">
                        {{$ratingType->name}} отзывов –
                        @if ($ratingType->slug == 'positive')
                            {{$positiveRatingsCount + $positiveCommentsCount}}
                        @elseif ($ratingType->slug == 'negative')
                           {{$negativeRatingsCount + $negativeCommentsCount}}
                        @elseif ($ratingType->slug == 'neutral')
                           {{$neutralRatingsCount + $neutralCommentsCount}}
                        @endif

                    </span>
                </div>
            @endforeach
          </div>
        </div>
      </div>

    @endif
      <div class="card mb-4 bg-white">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="fw-bold">Основные данные</div>
                <div class="divider_v"></div>
            </div>
            <div class="row">
                <div class="col-md-4 d-flex align-items-start">
                    @if(!empty($additionalInfo) && $imgPath = $additionalInfo->img_path)
                        <img src="/storage/{{$imgPath}}" alt="Telegram d" class="me-3" style="width: 80px;">
                    @endif
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <img src="/images/logos/{{$check->logo_path}}" loading="lazy" alt="" class="me-2">
                            <div class="text-muted">
                                <a href="@if($check->url){{$check->url}}/@endif{{$q}}" target="_blank">
                                    @if($check->url)
                                    {{$check->url}}/
                                    @endif
                                    {{$q}}
                                </a>
                            </div>
                        </div>
                        @if (isset($domainInfo) && count($domainInfo))
                            <div class="flx_vr_lf">
                                <div class="flx_hz_cnt">
                                    <img src="/images/ic_inf_dom.svg" loading="lazy" alt="" class="ic_inf">
                                    <div class="inf_txt">Домен: </div>
                                    <div class="def_txt_lnk mn ml-3" style="margin-left: 5px!important"> {{$q}}</div>
                                </div>
                                @if(isset($domainInfo['ip']))
                                    <div class="flx_hz_cnt"><img src="/images/ic_inf_ip.svg" loading="lazy" alt="" class="ic_inf">
                                        <div class="inf_txt">IP сервера:</div>
                                        <div class="inf_txt mn" style="margin-left: 5px!important">{{$domainInfo['ip']}}</div>
                                    </div>
                                @endif
                                @if(isset($domainInfo['region']))
                                    <div class="flx_hz_cnt"><img src="/images/ic_inf_place.svg" loading="lazy" alt="" class="ic_inf">
                                        <div class="inf_txt">Местоположение IP:</div>
                                        <div class="inf_txt mn" style="margin-left: 5px!important">
                                            {{$domainInfo['region']}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    @if(!empty($additionalInfo) && $description = $additionalInfo->description)
                    <div class="description-text">
                        <h5>Описание</h5>
                        <p>{{$description}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <div class="card mb-4 bg-white">
        <div class="card-body">

                <div class="d-flex justify-content-between">
                    @foreach ($ratingTypes as $ratingType)

                        @if ($ratingType->ratings()->count())
                            <div class="">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="/images/ic_inf_bad.svg" loading="lazy" alt="" class="ic_inf">
                                        <b class="me-2 @if($ratingType['slug'] == 'positive') text-success @elseif($ratingType['slug'] == 'negative')) text-danger @else text-warning  @endif">
                                            {{$ratingType['name']}} отзыв
                                        </b>
                                        <div class="text-muted">
                                            @if ($ratingType->slug == 'positive')
                                                {{$positiveRatingsCount}}
                                            @elseif ($ratingType->slug == 'negative')
                                            {{$negativeRatingsCount}}
                                            @elseif ($ratingType->slug == 'neutral')
                                            {{$neutralRatingsCount}}
                                            @endif
                                             </div>
                                    </div>
                                @foreach ($ratingType->ratings as $ratingTypeRating)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-2">{{$ratingTypeRating->name}}:</div>
                                        <div class="text-muted">
                                            @if($ratingType->slug == 'positive')
                                            {{
                                            $comments->flatMap(function ($comment) use($ratingTypeRating) {
                                                return $comment->positiveRates()
                                                ->where('rating_id',$ratingTypeRating->id)
                                                ->get();
                                            })
                                            ->count();
                                            }}
                                            @elseif($ratingType->slug == 'negative')
                                            {{
                                            $comments->flatMap(function ($comment) use($ratingTypeRating) {
                                                return $comment->negativeRates()
                                                ->where('rating_id',$ratingTypeRating->id)
                                                ->get();
                                            })
                                            ->count();
                                            }}
                                            @else
                                            0
                                            @endif
                                             </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

        </div>
    </div>
    @if(isset($comments) && count($comments))
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                        <h2 class="h4 mb-0">Отзывы и комментарии</h2>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($comments as $comment)
            <div class="card mb-4 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <svg width="36" height="40" viewBox="0 0 36 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M35.4776 18.2514C35.1333 20.1033 34.6342 21.8073 34.0253 23.371C32.6279 26.9881 30.6716 29.8527 28.7702 32.0209C24.0589 37.3879 18.7988 39.6607 18.5767 39.7551L18.0003 40L17.4238 39.7551C17.2017 39.6607 11.9391 37.3879 7.22787 32.0209C5.85543 30.4572 4.45305 28.5262 3.25529 26.2101C2.95335 25.631 2.66639 25.029 2.3944 24.404H5.69573C6.68389 26.3708 7.93904 28.2252 9.46619 29.9675C12.8549 33.8295 16.5879 35.9314 17.9928 36.638C19.4151 35.9212 23.2105 33.7785 26.6042 29.8782C28.845 27.3018 30.4969 24.4755 31.5599 21.4093C31.5699 21.3838 31.5774 21.3558 31.5899 21.3277H27.1257V18.2514H35.4776Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive') green @else yellow @endif"></path>
                                    <path d="M35.8894 15.1751H32.8875C33.1196 12.5579 32.9973 9.8004 32.5107 6.91283L17.9978 3.17327L3.48744 6.91028C2.84115 10.7468 2.83366 14.3537 3.45749 17.7081C3.46498 17.7336 3.46997 17.7616 3.47247 17.7897C3.49991 17.9427 3.52986 18.0958 3.5623 18.2488H8.86739V21.3252H1.27158C0.992097 20.4043 0.752545 19.4375 0.557908 18.4274C-0.165741 14.6827 -0.255573 10.3412 0.707629 5.35935L0.892284 4.40533L17.9978 0L35.1059 4.40533L35.2906 5.35935C35.9893 8.96117 36.134 12.2263 35.8894 15.1751Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive') green @else yellow @endif"></path>
                                    <path d="M35.4776 18.2514C35.1333 20.1033 34.6342 21.8073 34.0253 23.371C32.6279 26.9881 30.6716 29.8527 28.7702 32.0209C24.0589 37.3879 18.7988 39.6607 18.5767 39.7551L18.0003 40L17.4238 39.7551C17.2017 39.6607 11.9391 37.3879 7.22787 32.0209C5.85543 30.4572 4.45305 28.5262 3.25529 26.2101C2.95335 25.631 2.66639 25.029 2.3944 24.404H5.69573C6.68389 26.3708 7.93904 28.2252 9.46619 29.9675C12.8549 33.8295 16.5879 35.9314 17.9928 36.638C19.4151 35.9212 23.2105 33.7785 26.6042 29.8782C28.845 27.3018 30.4969 24.4755 31.5599 21.4093C31.5699 21.3838 31.5774 21.3558 31.5899 21.3277H27.1257V18.2514H35.4776Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive') green @else yellow @endif"></path>
                                    <path d="M35.8894 15.1751H32.8875C33.1196 12.5579 32.9973 9.8004 32.5107 6.91283L17.9978 3.17327L3.48744 6.91028C2.84115 10.7468 2.83366 14.3537 3.45749 17.7081C3.46498 17.7336 3.46997 17.7616 3.47247 17.7897C3.49991 17.9427 3.52986 18.0958 3.5623 18.2488H8.86739V21.3252H1.27158C0.992097 20.4043 0.752545 19.4375 0.557908 18.4274C-0.165741 14.6827 -0.255573 10.3412 0.707629 5.35935L0.892284 4.40533L17.9978 0L35.1059 4.40533L35.2906 5.35935C35.9893 8.96117 36.134 12.2263 35.8894 15.1751Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive') green @else yellow @endif"></path>
                                    <path d="M18 10L20.4452 14.6345L25.6085 15.5279L21.9564 19.2855L22.7023 24.4721L18 22.16L13.2977 24.4721L14.0436 19.2855L10.3915 15.5279L15.5548 14.6345L18 10Z" fill="@if($comment->reviewType->slug == 'negative')red @elseif($comment->reviewType->slug == 'positive') green @else yellow @endif"></path>
                                </svg>
                            </div>
                            <div>{{$comment->reviewType->name}} отзыв</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div>{{$comment->created_at}}</div>
                            <div class="ms-2">
                                <a class="link-block" href="/user/257936">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 3C8.83203 3 3 8.83203 3 16C3 23.168 8.83203 29 16 29C23.168 29 29 23.168 29 16C29 8.83203 23.168 3 16 3ZM16 5C22.0859 5 27 9.91406 27 16C27 22.0859 22.0859 27 16 27C9.91406 27 5 22.0859 5 16C5 9.91406 9.91406 5 16 5ZM16 8C13.25 8 11 10.25 11 13C11 14.5156 11.707 15.8633 12.7812 16.7812C10.5312 17.9492 9 20.3008 9 23H11C11 20.2266 13.2266 18 16 18C18.7734 18 21 20.2266 21 23H23C23 20.3008 21.4688 17.9492 19.2188 16.7812C20.293 15.8633 21 14.5156 21 13C21 10.25 18.75 8 16 8ZM16 10C17.668 10 19 11.332 19 13C19 14.668 17.668 16 16 16C14.332 16 13 14.668 13 13C13 11.332 14.332 10 16 10Z" fill="currentcolor"></path>
                                    </svg>
                                    @if (auth() && auth()->user() && $comment->user_id == auth()->user()->id)
                                        Это я
                                    @else
                                    {{$comment->user->name}}
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <p>{{$comment->text}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center mb-4">Пока нет ни одного отзыва, Вы можете быть первым!</div>
    @endif
    @if(auth() && auth()->user() && (isset($comments) && !$comments->where('user_id',auth()->user()->id)->count()))
    <div class="card mb-4 bg-white">
        <div class="card-body">
            <form action="{{route('comment.store')}}" method="post">
                <input type="text" name="search" hidden value="{{$q}}">
                <input type="text" name="check_id" hidden value="{{$check->id}}">
                @csrf
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="fw-bold">Оценить</div>
                        <div class="divider_v"></div>
                        <div class="fw-bold">
                            @if($check->url){{$check->url}}/@endif{{$q}}
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    @foreach ($ratingTypes as $ratingType)
                        @if ($ratingType->ratings()->count())
                            <div class="">
                                <div class="d-flex align-items-center mb-3">
                                    {{-- <img src="/images/ic_inf_good.svg" loading="lazy" alt="" class="me-2"> --}}
                                    <b class="@if($ratingType['slug'] == 'positive') text-success @elseif($ratingType['slug'] == 'negative')) text-danger @else text-warning  @endif">
                                        {{$ratingType->name}}
                                    </b>
                                </div>
                                    @foreach ($ratingType->ratings as $ratingTypeRating)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="{{$ratingType->slug}}[]" value="{{$ratingTypeRating->id}}">
                                            <label class="form-check-label">{{$ratingTypeRating->name}}</label>
                                        </div>
                                    @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-4">
                    <div class="mb-3">
                        <textarea placeholder="Текст отзыва (максимум 2000 символов)." maxlength="2000" name="text" class="textarea form-control"></textarea>
                    </div>
                    <div class="d-flex mb-3">
                        @foreach ($ratingTypes as $ratingType)
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="review_type_id" value="{{$ratingType->id}}">
                            <label class="form-check-label">{{$ratingType->name}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Оценить аккаунт</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

@section('style')
<style>
    .divider_v {
        border-left: 1px solid #ddd;
        height: 20px;
        margin: 0 15px;
    }
    .inf_txt {
        margin: 0;
    }
    .rdo_txt {
        margin-left: 5px;
    }
    .textarea {
        width: 100%;
        resize: none;
    }
    .def_button {
        background-color: #007bff;
        color: white;
        border: none;
    }
    .def_button:hover {
        background-color: #0056b3;
    }
    .flx_hz_cnt {
        display: flex;
        align-items: center;
    }
    .flx_vr_lf {
        display: flex;
        flex-direction: column;
    }
    .flx_vr_lf_50 {
        width: 50%;
    }
    .flx_hz_fll {
        display: flex;
    }
    .pdd {
        padding: 15px;
    }
    .pdd_tp {
        padding-top: 15px;
    }
</style>
@endsection
