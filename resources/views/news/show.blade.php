@extends('layouts.app')
@section('title', $news->title)

@section('style')
  <style>
    #header-image {
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("{{ asset('storage/news/'.$news->image) }}");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      padding: 200px 0;
    }
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-4">
    <div class="row ml-0">
      <div class="col-12" id="header-image">
        <h1 class="h2 text-center text-white">{{ $news->title }}</h1>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-10 offset-1">
        {!! $news->content !!}
      </div>
    </div>
  </div>


@endsection

@section('js')

@endsection
