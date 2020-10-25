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
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 d-flex align-items-center" id="first-big-header">
        <div class="row w-100 m-0">
          <div class="col-lg-6 text-center text-white">
            <h1 class="font-weight-bolder">Asay Jurek</h1>
            <p>Селективный секонд хенд</p>
            <a href="#" class="btn btn-transparent btn-text-white">Перейти к покупкам</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-12">

      </div>
      <div class="col-lg-6 col-12">

      </div>
    </div>
  </div>
@endsection
