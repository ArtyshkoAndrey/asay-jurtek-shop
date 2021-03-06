@extends('layouts.app')
@section('title', $item->title)

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-4">
    <div class="row ml-0">
      <div class="col-lg-6">
        <div class="row">
          <div class="col-3 overflow-auto slick-overflow m-0 p-0">
            @forelse($item->photos as $photo)
              <img src="{{ asset('storage/items/' . $photo->name) }}" alt="{{ $item->title }}" id="img-{{$photo->id}}" class="img-fluid img-gallery @if($loop->first) mb-2 active @else my-2 @endif" onclick="changePhoto({{$photo->id}})">
            @empty
              <img src="{{ $item->placeholder() }}" alt="{{ $item->title }}" id="img-{{$item->id}}" class="img-fluid img-gallery mb-2 active" onclick="changePhoto({{$item->id}})">
            @endforelse
          </div>
          <div class="col-8">
{{--            <div style="position: relative">--}}
              @forelse($item->photos as $photo)
                <img src="{{ asset('storage/items/' . $photo->name) }}" alt="{{ $item->title }}" id="img-preview-{{$photo->id}}" class="img-fluid img-preview @if($loop->first) active @endif">
              @empty
                <img src="{{ $item->placeholder() }}" alt="{{ $item->title }}" id="img-preview-{{$item->id}}" class="img-fluid img-preview active ">
              @endforelse
{{--            </div>--}}
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="row ">
          <div class="col-12 mt-3 mt-lg-0 p-0">
            <h3 class="font-weight-normal">{{ $item->title }}</h3>
            <div class="text-muted">{!! $item->description !!}</div>
          </div>
          <div class="col-12 mt-4 p-0">
            <div class="row">
              <div class="col-auto">
                <p class="h3 font-weight-normal">{{ $item->cost($currency) }} {{ $currency->symbol }}</p>
              </div>
              <div class="col-auto">
                @guest
                  <button type="button" v-if="$store.state.cart.items.find(x => x.id === {{ $item->id }})" class="btn btn-green">Товар добавлен в корзину</button>
                  <button type="button" @click="addItemCart({{ $item }})" v-else class="btn btn-orange inverse">Добавить в корзину</button>
                @else
                  @if ($inCart)
                    <form action="{{ route('product.addCart', $item->id) }}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-green">Товар добавлен в корзину</button>
                    </form>
                  @else
                    <form action="{{ route('product.addCart', $item->id) }}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-orange inverse">Добавить в корзину</button>
                    </form>
                  @endif
                @endguest
              </div>
            </div>
          </div>
          <div class="col-12 p-0 mt-3">
            <hr>
          </div>
          <div class="col-12 p-0 mt-3">
            <p class="h5 font-weight-normal">Характеристики товара</p>

            <table class="table table-bordered w-100 w-md-50">
              <tbody>
                <tr>
                  <th class="text-muted font-weight-normal">Категория</th>
                  <td class="font-weight-bolder">
                    @foreach($item->categories as $index => $cat)
                      {{ $item->categories->count() == $index + 1 ? $cat->name : $cat->name . ', ' }}
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <th class="text-muted font-weight-normal">Размер</th>
                  <td class="font-weight-bolder">{{ $item->skus->title }}</td>
                </tr>
                <tr>
                  <th class="text-muted font-weight-normal">Состояние</th>
                  <td class="font-weight-bolder">{{ $item->status }}</td>
                </tr>
                <tr>
                  <th class="text-muted font-weight-normal">Вес</th>
                  <td class="font-weight-bolder">{{ $item->weight }} кг.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @if (isset($item->history))
      <div class="row">
        <div class="col-12">
          <button class="btn btn-orange ml-0 ml-md-auto d-block d my-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            История вещи
          </button>
          <div class="collapse" id="collapseExample">
            <div class="card card-body rounded-0">
              {!! $item->history !!}
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

  <div class="container-fluid mt-5 mt-ld-5">
    <div class="row mt-0 mt-ld-5">
      <div class="col-12 mt-0 mt-ld-5">
        <h4 class="text-center text-lg-left">C этим так же подойдет</h4>
      </div>
      @foreach($items as $itemC)
        <div class="col-lg-3 mt-4 col-sm-6 col-12 pl-sm-0">
          @include('layouts.item', array('item' => $itemC))
        </div>
      @endforeach
    </div>
  </div>

@endsection

@section('js')
  <script>
    let imgs = $('.img-gallery')
    let imgsP = $('.img-preview')

    let idImg = {{count($item->photos) > 0 ? $item->photos[0]->id : $item->id}}

    function changePhoto (id) {
      imgs.removeClass('active');
      imgsP.removeClass('active');
      $('#img-' + id).addClass('active');
      $('#img-preview-'+ id).addClass('active');
      imgs.parent().height($('#img-preview-'+ id).height())
      idImg = id
    }
    $( document ).ready(function() {
      console.log(idImg)
      changePhoto(idImg)
    });
    $( window ).resize(function() {
      changePhoto(idImg)
    });
  </script>
@endsection
