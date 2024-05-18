@extends('layouts.main')

@section('content')

<div class="card-container">

    <h2 class="page-title">My links</h2>

    @if(count($urls) > 0)

        <div class="my-links-list">

            @foreach($urls as $url)

                <div class="my-links-list-item">

                    <div class="original-link">

                        <a href="{{ $url->full_URL }}">{{ $url->full_URL }}</a>

                    </div>

                    <div class="link-actions">

                        <a href="/URLs/{{ $url->short_URL }}" class="btn-default">VIEW</a>

                        <div class="copy-shortened-link" data-link="{{url($url->short_URL)}}">
                            COPY
                        </div>

                        <button class="btn-danger">DELETE</button>

                    </div>

                </div>

            @endforeach

        </div>
        
        {{ $urls->links("partials.url-pagination") }}

    @else

        <p class="mt-0">Looks like you haven't shortened any links yet.</p>

        <a href="/" class="btn-default">
            SHORTEN A LINK
        </a>

    @endif

</div>

@endsection