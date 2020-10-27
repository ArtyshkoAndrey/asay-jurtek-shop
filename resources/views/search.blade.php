@extends('layouts.app')
@section('title', 'Главная')

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-12">
        <h3>Результаты поиска “{{ $q }}”</h3>
      </div>
    </div>
    <div class="row m-0">
      @forelse($items as $item)
        <div class="col-lg-3 mt-4 col-sm-6 col-12 pl-sm-0">
          @include('layouts.item', array('item'=>$item))
        </div>
      @empty
        <div class="col-12 text-center">
{{--          <p class="h3 font-weight-bolder">Таких товаров нет ((</p>--}}
        </div>
      @endforelse
    </div>
  </div>

@endsection

@section('js')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      resizeImgItems();
      window.onresize = () => {
        resizeImgItems();
      }
    }, false);

    function resizeImgItems() {
      let itemsImg = $('.item img');
      itemsImg.height(itemsImg.width())
    }
  </script>
@endsection
