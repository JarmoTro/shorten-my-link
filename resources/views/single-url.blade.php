@extends('layouts.main')

@section('content')

<div class="card-container">

    <div class="content-single-url">

        <h1>Your shortened link</h1>

        <div class="shortened-link">

            <div class="shortened-link-inner">

               <a href="{{ url($url->short_URL) }}"> {{ url($url->short_URL) }} </a>
                
            </div>

            <div class="copy-shortened-link" data-link="{{url($url->short_URL)}}">
                COPY
            </div>

        </div>

        <div class="original-link">
            Original link: <a href="{{ url($url->full_URL) }}">{{ url($url->full_URL) }}</a>
        </div>

    </div>

</div>

@endsection