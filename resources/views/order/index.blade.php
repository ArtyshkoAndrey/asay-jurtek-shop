@extends('layouts.app')
@section('title', 'Корзина')

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-2">
    <div class="row justify-content-center">
      <div class="col-12">
        <p class="font-weight-bolder h4">Корзина</p>
      </div>
      <div class="col-md-8">
        @auth
          @foreach($cartItems as $item)
            <div class="row mt-2 mx-0 border cart-items">
              <div class="col-3 p-0">
                <img src="{{ $item->placeholder() }}" alt="{{ $item->title }}" class="w-100" style="object-fit: cover">
              </div>
              <div class="col-md-5 col-9">
                <div class="row h-100 align-items-center">
                  <div class="col-12">
                    <p class="h5 font-weight-normal">{{ $item->title }}</p>
                    <p class="h6">
                      <span class="text-muted">Размер: </span><span>{{ $item->skus->title }}</span>
                      <span class="text-muted ml-1">Состояние: </span><span>{{ $item->status }}</span>
                    </p>
                  </div>
                  <div class="col-md-auto d-block d-md-none col-12 ml-auto">
                    <div class="row justify-content-md-start justify-content-between h-100">
                      <div class="col-md-12 col-auto d-flex justify-content-end">
                        <form class="" action="{{ route('product.removeCart', $item->id) }}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" name="submit" class="p-0 btn bg-transparent border-0 link ml-auto mt-md-3"><i class="icon-trash h3"></i></button>
                        </form>
                      </div>
                      <div class="col-md-12 order-first order-md-last col-auto d-flex justify-content-end">
                        <p class="h3 font-weight-normal mr-4">{{ $item->cost($currency) }} {{ $currency->symbol }}</p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-auto d-md-block d-none col-12 ml-auto">
                <div class="row justify-content-md-start justify-content-between h-100">
                  <div class="col-md-12 col-auto d-flex justify-content-end">
                    <form class="" action="{{ route('product.removeCart', $item->id) }}" method="post">
                      @csrf
                      @method('delete')
                      <button type="submit" name="submit" class="p-0 btn bg-transparent border-0 link ml-auto mt-md-3"><i class="icon-trash h3"></i></button>
                    </form>
                  </div>
                  <div class="col-md-12 order-first order-md-last col-auto d-flex justify-content-end">
                    <p class="h3 font-weight-normal mr-4">{{ $item->cost($currency) }} {{ $currency->symbol }}</p>
                  </div>
                </div>

              </div>
            </div>
          @endforeach
        @else
          <div v-for="item in $store.state.cart.items" class="row mt-2 mx-0 border cart-items">
            <div class="col-3 p-0">
              <img v-if="item.photos.length > 0" :src="'{{ asset('storage/items/') }}' + '/' + item.photos[0].name" :alt="item.title" class="w-100" style="object-fit: cover">
              <img v-else :src="'{{ asset('images/unnamed.png') }}'" :alt="item.title" class="w-100" style="object-fit: cover">
            </div>
            <div class="col-md-5 col-9">
              <div class="row h-100 align-items-center">
                <div class="col-12">
                  <p class="h5 font-weight-normal">@{{ item.title }}</p>
                  <p class="h6">
                    <span class="text-muted">Размер: </span><span>@{{ item.skus.title }}</span>
                    <span class="text-muted ml-1">Состояние: </span><span>@{{ item.status }}</span>
                  </p>
                </div>
                <div class="col-md-auto d-block d-md-none col-12 ml-auto">
                  <div class="row justify-content-md-start justify-content-between h-100">
                    <div class="col-md-12 col-auto d-flex justify-content-end">
                      <button type="button" @click="$store.commit('removeItem', item.id)" name="submit" class="p-0 btn bg-transparent border-0 link ml-auto mt-md-3"><i class="icon-trash h3"></i></button>
                    </div>
                    <div class="col-md-12 order-first order-md-last col-auto d-flex justify-content-end">
                      <p class="h3 font-weight-normal mr-4">@{{ $cost((item.on_sale ? item.price_sale : item.price) * $store.state.currency.ratio ) }} @{{ $store.state.currency.symbol }}</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-auto d-md-block d-none col-12 ml-auto">
              <div class="row justify-content-md-start justify-content-between h-100">
                <div class="col-md-12 col-auto d-flex justify-content-end align-items-start">
                  <button type="button" @click="$store.commit('removeItem', item.id)" name="submit" class="p-0 btn bg-transparent border-0 link ml-auto mt-md-3"><i class="icon-trash h3"></i></button>
                </div>
                <div class="col-md-12 order-first order-md-last col-auto d-flex justify-content-end">
                  <p class="h3 font-weight-normal mr-4">@{{ $cost((item.on_sale ? item.price_sale : item.price) * $store.state.currency.ratio ) }} @{{ $store.state.currency.symbol }}</p>
                </div>
              </div>

            </div>
          </div>
        @endauth
      </div>
      <div class="col-md-4 mt-md-0 mt-4">
        <div class="row">
          <div class="col-12 justify-content-end d-flex">
            @guest
              <a href="{{ route('login') }}" class="text-decoration-none">Войдите в аккаунт, чтобы оплачивать быстрее</a>
            @endguest
          </div>
          <div class="col-12">
            <a href="{{ route('order.create') }}" class="btn btn-orange d-block w-100 mt-2 py-3">Перейти к оплате</a>
          </div>
          <div class="col-12">
            @auth
              <div class="border w-100 py-3 px-3 mt-2 d-flex justify-content-between">
                <p class="h5 font-weight-normal m-0">Итог заказа</p>
                <p class="h5 font-weight-bolder m-0">{{ $priceAmount }} {{ $currency->symbol }}</p>
              </div>
              <p class="text-muted">*Без учёта доставки</p>
            @else
              <div class="border w-100 py-3 px-3 mt-2 d-flex justify-content-between">
                <p class="h5 font-weight-normal m-0">Итог заказа</p>
                <p class="h5 font-weight-bolder m-0">@{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</p>
              </div>
              <p class="text-muted">*Без учёта доставки</p>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
  <script>

    $('.cart-items img').height($('.cart-items img').width())

    $(window).resize(function () {
      $('.cart-items img').height($('.cart-items img').width())
    })
  </script>
@endsection
