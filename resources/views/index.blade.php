@extends('layouts.app')
@section('title', 'Главная')

@section('style')
  <style>
    #first-big-header {
      background: linear-gradient(90deg, #D1BC8A 50%, rgba(209, 188, 138, 0) 100%), url("http://zakaz/images/586e6940ea673b0ebbdc6668f59ca32a.jpg") no-repeat right top;
      min-height: 500px;
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
