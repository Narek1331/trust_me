@extends('layouts.app')
@section('content')
<div class="container my-4">
    {{-- <div class="mb-4">
        <h2 class="text-center">
        </h2>
    </div> --}}

    {{-- <div id="ads_block_top" class="mb-4">
        <div class="alert alert-info text-center" role="alert">
        </div>
    </div> --}}

    <div class="container">
                <div class="card bg-white">
                        <img src="/storage/{{$news->img_path}}" class="card-img-top" alt="{{$news->title}}" style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                {{$news->title}}
                            </h5>
                            <p class="card-text">
                                {{$news->text}}
                            </p>

                        </div>
                    </div>
    </div>


    {{-- <div id="ads_block_down">
        <div class="alert alert-info text-center" role="alert">
        </div>
    </div> --}}
</div>
@endsection
