@extends('layouts.app')
@section('title', 'Заказать')

@section('style')
  <style>
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
      opacity: 0
    }
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-2">
    <order :auth="{{ (int) auth()->check() }}" :itemsprop="{{ json_encode($cartItems) }}" inline-template>
      <div class="row">
        <div class="col-md-8">
          <div class="row">
            <div class="col-12">
              <p class="h4 font-weight-bolder">Адрес доставки</p>
            </div>
            <div class="col-md-10">
              <div class="row">
                <div class="col-md-6 mt-2">
                  <select name="country" v-model="country" class="form-control w-100 h-100" id="country"></select>
                </div>
                <div class="col-md-6 mt-2">
                  <select name="city" v-model="city" class="form-control w-100" id="city"></select>
                </div>
                <div class="col-md-6 mt-2">
                  <input type="text" name="address" id="address" class="form-control rounded-0" placeholder="Точный адрес*">
                </div>
              </div>
            </div>

            <div class="col-12 mt-3">
              <p class="h4 font-weight-bolder">Контактные данные</p>
            </div>
            <div class="col-md-10">
              <div class="row">
                <div class="col-md-6 mt-2">
                  <input type="text" name="firstname" id="firstname" class="form-control rounded-0" placeholder="Имя*">
                </div>
                <div class="col-md-6 mt-2">
                  <input type="text" name="lastname" id="lastname" class="form-control rounded-0" placeholder="Фамилия*">
                </div>
                <div class="col-md-6 mt-2">
                  <input type="text" name="phone" id="phone" class="form-control rounded-0" placeholder="Телефон*">
                </div>
                <div class="col-md-6 mt-2">
                  <input type="email" name="email" id="email" class="form-control rounded-0" placeholder="E-mail *">
                </div>
              </div>
            </div>

            <div class="col-12 mt-3">
              <p class="h4 font-weight-bolder">Доставка</p>
            </div>

            <div class="col-md-12">
              <transition-group name="fade" tag="div" class="row">
                <div class="col-12 mt-3" v-for="company in getCompanies" :key="company.id">
                  <a href="javascript:" @click="setCompany(company)" :class="'d-block text-decoration-none text-dark border p-3 transport-link' + (company === getCompany ? ' active' : '')">
                    <div class="row">
                      <div class="col-md-8">
                        <p class="h5 font-weight-bolder">@{{ company.name }}</p>
                        <p class="mb-0">@{{ company.description }}</p>
                      </div>
                      <div class="col my-auto">
                        <p class="m-0 h6 font-weight-bolder text-right">@{{ company.costedTransfer === 0 ? 'Бесплатно' : ($cost(company.costedTransfer * $store.state.currency.ratio) + ' ' + $store.state.currency.symbol) }}</p>
                      </div>
                    </div>
                  </a>
                </div>
              </transition-group>
            </div>



            <div class="col-12 mt-3">
              <p class="h4 font-weight-bolder">Оплата</p>
            </div>
            <div class="col-md-6 mt-3">
              <a href="javascript:" class="d-block text-decoration-none text-dark border p-3 active transport-link">
                <div class="row">
                  <div class="col-md-8">
                    <p class="h5 font-weight-bolder">Оплата при получении</p>
                    <p class="mb-0">Оплатите курьеру или в магазине после получения</p>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-6 mt-3">
              <a href="javascript:" class="d-block text-decoration-none text-dark border p-3 transport-link">
                <div class="row">
                  <div class="col-md-8">
                    <p class="h5 font-weight-bolder">Оплата картой</p>
                    <p class="mb-0">Оплатите онлайн любым удобным способом</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-12 mt-3">
              <button class="btn btn-orange">Завершить и оплатить 20 000 тг.</button>
            </div>
          </div>
        </div>
        <div class="col-md-4 mt-5 mt-md-0">
          <div class="row justify-content-end">
            <div class="col-auto">
              <a href="{{ route('login') }}" class="text-decoration-none">Войдите в аккаунт, чтобы оплачивать быстрее</a>
            </div>
          </div>
          @auth
            <div class="row mt-2">
              <div class="col-12 border p-3">
                <div class="row m-0 justify-content-between">
                  <p>Сумма покупок</p>
                  <p>{{ $priceAmount }} {{ $currency->symbol }}</p>
                </div>
                <div class="row m-0 justify-content-between">
                  <p>Доставка</p>
                  <p>20 000 тг.</p>
                </div>
                <div class="row m-0 justify-content-between">
                  <p class="font-weight-bolder mb-0">Итог заказа</p>
                  <p class="font-weight-bolder mb-0">20 000 тг.</p>
                </div>
              </div>
            </div>
          @else
            <div class="row mt-2">
              <div class="col-12 border p-3">
                <div class="row m-0 justify-content-between">
                  <p>Сумма покупок</p>
                  <p>@{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</p>
                </div>
                <div class="row m-0 justify-content-between">
                  <p>Доставка</p>
                  <p>20 000 тг.</p>
                </div>
                <div class="row m-0 justify-content-between">
                  <p class="font-weight-bolder mb-0">Итог заказа</p>
                  <p class="font-weight-bolder mb-0">20 000 тг.</p>
                </div>
              </div>
            </div>
          @endauth
          <div class="row mt-3">
            <div class="col-12">
              <p class="m-0 font-weight-bolder h5">Позиции заказа</p>
            </div>

            @auth
              @foreach($cartItems as $item)
                <div class="col-12 mt-3">
                  <div class="row">
                    <div class="col-4">
                      <img src="{{ $item->placeholder() }}" alt="{{ $item->title }}" class="w-100 items-image" style="object-fit: cover">
                    </div>
                    <div class="col-6 d-flex justify-content-around flex-column">
                      <p>{{ $item->title }}</p>
                      <p class="m-0">{{ $item->cost($currency) }} {{ $currency->symbol }}</p>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div v-for="item in $store.state.cart.items" class="col-12 mt-3">
                <div class="row">
                  <div class="col-4">
                    <img v-if="item.photos.length > 0" :src="'{{ asset('storage/items/') }}' + '/' + item.photos[0].name" :alt="item.title" class="w-100 items-image" style="object-fit: cover">
                    <img v-else :src="'{{ asset('images/unnamed.png') }}'" :alt="item.title" class="w-100 items-image" style="object-fit: cover">
                  </div>
                  <div class="col-6 d-flex justify-content-around flex-column">
                    <p>@{{ item.title }}</p>
                    <p class="m-0">@{{ $cost((item.on_sale ? item.price_sale : item.price) * $store.state.currency.ratio ) }} @{{ $store.state.currency.symbol }}</p>
                  </div>
                </div>
              </div>
            @endauth

          </div>
        </div>
      </div>
    </order>
  </div>

@endsection

@section('js')
  <script>
    $(window).resize(function () {
      $('.items-image').height($('.items-image').width())
      // $('.select2 ').width($('#address').width())
    })
    $(document).ready(() => {

      $('.items-image').height($('.items-image').width())


      $('#city').select2({
        width: '100%',
        placeholder: '*Город',
        "language": {
          "noResults": function(){
            return "Нет результатов";
          },
        },
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.city', '') }}' + '/' + params.term;
          },
          processResults: function (data) {
            return {
              results: data.items.map((e) => {
                return {
                  text: e.name,
                  id: e.id
                };
              })
            };
          }
        }
      });
      $('#country').select2({
        width: '100%',
        placeholder: '*Страна',
        "language": {
          "noResults": function(){
            return "Нет результатов";
          },
        },
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.country', '') }}' + '/' + params.term;
          },
          processResults: function (data) {
            return {
              results: data.items.map((e) => {
                return {
                  text: e.name,
                  id: e.id
                };
              })
            };
          }
        }
      });
    })
  </script>
@endsection
