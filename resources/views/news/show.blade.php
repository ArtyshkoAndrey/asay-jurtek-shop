@extends('layouts.app')
@section('title', $news->title)

@section('style')
  <style>
    #header-image {
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("{{ asset('storage/news/'.$news->image) }}") no-repeat center;
      background-size: cover;
      padding: 200px 0;
    }

    #news img {
      width: 100%;
      height: auto;
    }
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-4 px-0">
    <div class="row ml-0">
      <div class="col-12 px-0 m-0" id="header-image">
        <div class="row justify-content-center">
          <div class="col-10">
            <h1 class="h2 text-center text-white">{{ $news->title }}</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-10 offset-1" id="news">
        {!! $news->content !!}
      </div>
    </div>
  </div>


@endsection

@section('js')

@endsection
