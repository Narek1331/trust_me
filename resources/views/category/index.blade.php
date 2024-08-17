@extends('layouts.app')
@section('content')
<div class="container my-4">
    <div class="mb-4">
        <h2 class="text-center">Разделы статей</h2>
    </div>

    {{-- <div id="ads_block_top" class="mb-4">
        <div class="alert alert-info text-center" role="alert">
        </div>
    </div> --}}

    <div class="container">
        <div class="row">
            @foreach ($newsCategories as $newsCategory)
                <a class="col-md-4 col-sm-6 col-xs-12 mb-4 text-decoration-none text-reset" href="{{route('category.show',['id'=>$newsCategory->id])}}">
                    <div class="card bg-white">
                        <img src="/storage/{{$newsCategory->img_path}}" class="card-img-top" alt="{{$newsCategory->title}}" style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                {{$newsCategory->title}}
                            </h5>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>


    {{-- <div id="ads_block_down">
        <div class="alert alert-info text-center" role="alert">
        </div>
    </div> --}}
</div>
@endsection
