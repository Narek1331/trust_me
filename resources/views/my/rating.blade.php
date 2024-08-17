@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <!-- Profile Edit Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <a href="{{ route('home') }}" class="text-white">
                        {{ __('Profile') }}
                    </a>
                    > {{ __('My Ratings') }}
                </div>

                <div class="card-body">
                    @foreach ($comments as $comment)
                        <div class="card mb-4 border-primary">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4">
                                    {{$comment->search}}
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        @if($comment->positiveRates()->count())
                                            <div class="mb-3">
                                                <h6 class="text-success">
                                                    {{ __('Positive Reviews') }}
                                                </h6>
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($comment->positiveRates as $positiveRate)
                                                        <li class="list-group-item">
                                                            {{$positiveRate->name}}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($comment->negativeRates()->count())
                                            <div class="mb-3">
                                                <h6 class="text-danger">
                                                    {{ __('Negative Reviews') }}
                                                </h6>
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($comment->negativeRates as $negativeRate)
                                                        <li class="list-group-item">
                                                            {{$negativeRate->name}}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
