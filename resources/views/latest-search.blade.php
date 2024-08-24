@extends('layouts.app')
@section('content')

    <div class="container mt-5">
        <div class="card mb-4 bg-white">
            <div class="card-body">
                <ul class="list-group">
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($searches as $index => $search)
                        <li class="list-group-item mt-2 d-flex justify-content-between">
                            <div>
                                <b class="mr-2">{{ $counter++ }}.</b>
                            <a class="btn" href="/search/{{$search->check->slug}}/{{$search->text}}">
                                @if($search->check)
                                    @if($search->check->parentCheck)
                                        {{ $search->check->parentCheck->name }} &gt;
                                    @endif
                                    {{ $search->check->name }} &gt;
                                @endif
                                {{ $search->text }}
                            </a>
                            </div>
                            <b class="mr-2">{{ $search['created_at'] }}</b>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
