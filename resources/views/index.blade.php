@extends('layouts.app')
@section('title', 'Главная')

@section('style')
  <style>
    #first-big-header {
      position: relative;
      @if($header->gradient)
        background: linear-gradient({{ $header->gradient_position === 'right-to-left' ? '270deg' : '90deg' }}, {{ $header->color_gradient }} 50%, rgba(209, 188, 138, 0) 100%);
      @endif
      min-height: 500px;
    }
    #first-big-header::before {
      background: url("{{ $header->image }}") no-repeat left top;
      background-size: cover;
      min-height: 500px;
      content: '';

      width: {{ $header->width . '%' }};

      @if($header->position === 'left')
        left: 0;
      @elseif($header->position === 'right')
        right: 0;
      @endif
      z-index: -1;
      position: absolute;
    }

    .promotion {
     min-height: 655px; 
    }

    .promotion>div {
      opacity: 0;
      transition: 1s;
      background: rgba(209, 188, 138, 0.5);
      min-height: 500px;
    }

    .promotion:hover>div {
      opacity: 1;
    }

    #secondPromotion {
      background: url("{{ asset('images/7b7c7d98382e7221ab48a124b02f205c.jpg') }}");
      background-size: cover;
    }

    #therdPromotion {
      background: url("{{ asset('images/7b7c7d98382e7221ab48a124b02f205c.jpg') }}");
      background-size: cover;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row m-0">
      <div class="col-12 d-flex align-items-center" id="first-big-header">
        <div class="row w-100 m-0">
          <div class="col-lg-6 text-center text-white">
            <h1 class="font-weight-bolder">Asay Jurek</h1>
            <p>Селективный секонд хенд</p>
            <a href="#" class="btn btn-transparent btn-text-white">Перейти к покупкам</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-12 p-0 mt-4 pr-lg-3">
        <div class="promotion h-100 h-100 d-flex" id="secondPromotion">
          <div class="w-100 h-100 d-flex align-items-center flex-column justify-content-center">
          <h3 class="font-weight-bolder text-white ">Asay Jurek Vintage home</h4>
          <a href="#" class="btn btn-transparent btn-text-white rounded-0">Перейти к покупкам</a>
        </div>
        </div>
      </div>

      <div class="col-lg-6 col-12 p-0 mt-4 pl-lg-3">
        <div class="promotion h-100 h-100 d-flex" id="therdPromotion">
          <div class="w-100 h-100 d-flex align-items-center flex-column justify-content-center">
          <h3 class="font-weight-bolder text-white ">Asay Jurek Vintage home</h4>
          <a href="#" class="btn btn-transparent btn-text-white rounded-0">Перейти к покупкам</a>
        </div>
        </div>
      </div>

    </div>
  </div>
@endsection
