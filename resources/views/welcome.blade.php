@extends('layouts.app')

@section('content')
    <div class="main-content py-5">
        <div class="container">
            <div class="button-search-container">
                <form action="">
                    <ul class="nav nav-tabs justify-content-center mt-4" id="myTab" role="tablist">
                        @foreach ($checks as $index => $check)
                            <li class="nav-item mx-2" role="presentation" onclick="tabClick('{{$check['slug']}}')">
                                <input class="btn-check" type="radio" name="checkId" id="{{$check['slug']}}-tab" data-bs-toggle="tab" data-bs-target="#{{$check['slug']}}" role="tab" aria-controls="{{$check['slug']}}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}" {{ $index === 0 ? 'checked' : '' }}>
                                <label class="btn btn-primary" for="{{$check['slug']}}-tab">
                                    {{$check['name']}}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-4" id="myTabContent">
                        @foreach ($checks as $index => $check)
                            @if($check->childrenChecks()->count())
                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{$check['slug']}}" role="tabpanel" aria-labelledby="{{$check['slug']}}-tab">
                                    <div class="input-group mt-3 mx-auto" style="max-width: 800px;">
                                        <select class="form-select" name="child_check_id" id="{{$check['slug']}}-child-check">
                                            @foreach ($check->childrenChecks as $childrenCheckNum => $childrenCheck)
                                                <option value="{{$childrenCheck['slug']}}" @if ($childrenCheckNum == 0) selected @endif>
                                                    {{$childrenCheck['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control" placeholder="Название аккаунта" aria-label="Название аккаунта" id="social-input-{{$check['slug']}}" />
                                        <button class="btn btn-danger" type="button" onclick="logValues('{{$check['slug']}}')">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="{{$check['slug']}}" role="tabpanel" aria-labelledby="{{$check['slug']}}-tab">
                                    <div class="input-group mt-3 mx-auto" style="max-width: 800px;">
                                        <input type="text" class="form-control" placeholder="{{$check['name']}}" aria-label="{{$check['name']}}" aria-describedby="basic-addon2" id="social-input-{{$check['slug']}}" />
                                        <button class="btn btn-danger" type="button" onclick="logValues('{{$check['slug']}}')">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
        @if($newsCategories && count($newsCategories))
            <div class="container my-5">
                <div class="mb-4">
                    <h2 class="text-center">Разделы статей</h2>
                </div>

                <div class="row g-4">
                    @foreach ($newsCategories as $newsCategory)
                        <div class="col-md-4 col-sm-6">
                            <a href="{{route('category.show',['id'=>$newsCategory->id])}}" class="text-decoration-none text-reset">
                                <div class="card h-100 shadow-sm">
                                    <img src="/storage/{{$newsCategory->img_path}}" class="card-img-top" alt="{{$newsCategory->title}}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">
                                            {{$newsCategory->title}}
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script>
        function tabClick(slug) {
            let siteTab = document.getElementById('site');
            if (slug !== 'site' && siteTab) {
                siteTab.classList.remove('active', 'show');
            }
        }

        function logValues(slug) {
            const checkSlug = document.querySelector('input[name="checkId"]:checked')?.id.replace('-tab', '');
            let inputValue = document.querySelector(`#social-input-${slug}`)?.value;
            const childCheckSlug = document.querySelector(`#${slug}-child-check`)?.value;
            const targetSlug = childCheckSlug || checkSlug;

            if (inputValue && targetSlug) {
                inputValue = inputValue.replace(/(https?:\/\/|www\.)/g, '');
                location.href = `/search/${targetSlug}/${inputValue}`;
            }
        }
    </script>
@endsection
