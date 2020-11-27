@extends('layouts.app')
@section('title', 'Наш блог')

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-2" id="filtered">
    <div class="row justify-content-end">
      <div class="col-auto dropdown">
        <a href="#" class="text-dark dropdown-toggle text-decoration-none" role="button" id="dropdownOrderLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if($filter['order'] === 'sort-old')
            <i class="fas fa-sort-amount-down"></i> С начало старые
          @elseif($filter['order'] === 'sort-new')
            <i class="fas fa-sort-amount-up"></i> Сначало новые
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownOrderLink">
          <a href="#" role="button" onclick="orderSort('sort-old')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-old' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> С начало старые</a>
          <a href="#" role="button" onclick="orderSort('sort-new')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-new' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> С начало новые</a>
        </div>
      </div>
      <form action="{{ route('news.index')  }}" id="order-form" class="d-none" method="get">
        <input type="hidden" id="order" value="{{ $filter['order'] }}">
      </form>
    </div>
    <div class="row">
      <div class="col-12">
        <hr>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      @foreach($newses as $news)
        <div class="col-lg-3 mt-4 col-sm-6 col-12 pl-sm-0">
          @include('layouts.news', array('news'=>$news, 'slider' => false))
        </div>
      @endforeach
    </div>
    <div class="row justify-content-center mt-4">
      <div class="col-auto">
        {{ $newses->onEachSide(1)->appends($filter)->links('vendor.pagination.bootstrap-4') }}
      </div>
    </div>
  </div>

@endsection

@section('js')
  <script>
    $("#filtered .dropdown-menu").on('click', function (event) {
      event.stopPropagation();
    });

    function orderSort (type) {
      $('#order').val(type)
      $('#order-form').submit()
    }
  </script>
@endsection
