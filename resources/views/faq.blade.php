@extends('layouts.main')

@section('content')

<div class="card-container">

    @include("partials.accordion",
    ["title" => "How does shortenmylink.com profit?",
    "content" => "This application is purely a hobby project made by an individual.
    There is no monetization or customer-business relationship of any kind,
    every feature is designed to benefit the user."])

    @include("partials.accordion",
    ["title" => "Can I enter sensitive links into this application?",
    "content" => "This is an extremely bad idea, as all links are public and someone could guess your link."])

    @include("partials.accordion",
    ["title" => "Why did my shortened link stop working?",
    "content" => "Most likely the link has expired or been deleted."])

    <p>If you have any questions that remained unaswered, feel free to send a message to <a href="mailto:contact@shortenmylink.com">contact@shortenmylink.com</a>.</p>

</div>

@endsection