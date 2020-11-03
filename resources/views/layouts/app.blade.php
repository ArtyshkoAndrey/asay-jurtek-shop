<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Asay Jurek - @yield('title')</title>
  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/icon.css') }}">
</head>
<body class="{{ \App\Helpers::route_class() }}-page">
  @yield('style')
  <div id="app" class="px-md-5 pt-1 px-0">
    @if($errors->any())
      @foreach ($errors->all() as $error)
        <div class="alert alert-warning alert-dismissible fade show position-absolute" id="error-alert" role="alert">
          <strong>Ошибка!</strong> {{ $error }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endforeach
    @endif
    <div class="container-fluid bg-white" id="navbar">
      <div class="row">
        <nav class="navbar navbar-light w-100 navbar-expand bg-transparent pt-0">
          <a class="navbar-brand h-100" href="{{ url('/') }}"><img src="{{ asset('images/logo.jpg') }}" alt="logo" class="h-100 w-auto"></a>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100">
              <li class="nav-item d-none d-lg-block">

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdownfirstLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clothes and accessories</a>
                  <div class="dropdown-menu dropdown-shadow navbar-dropdown-big rounded-0 border-0 py-4 px-4" aria-labelledby="dropdownfirstLink" id="firstLink">
                    <div class="row">
                      <div class="col-xl-4 col-lg-6">
                        <div class="row h-100 align-items-stretch">
                          <div class="col-4">
                            <img src="{{ asset('images/logo.jpg') }}" alt="logo" class="img-fluid">
                          </div>
                          <div class="col-12 d-flex flex-column justify-content-end">
                            <p class="font-weight-bolder h5">Одежда и аксессуары</p>
                            <a href="{{ route('product.all', ['p' => 56]) }}" class="text-decoration-none">Смотреть все товары</a>
                          </div>
                        </div>
                      </div>
                      <div class="col border-left d-flex align-items-center">
                        <div class="row pl-3" id="clothes-and-acc">
                          <a href="{{ route('product.all', ['p' => 56, 'sex' => 'male']) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/male.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Мужчинам</p>
                          </a>
                          <a href="{{ route('product.all', ['p' => 56, 'sex' => 'female']) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/female.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Женщинам</p>
                          </a>
                          <a href="{{ route('product.all', ['p' => 56, 'sex' => 'children']) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/children.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="{{ route('product.all', ['p' => 56]) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/clothes.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Одежда</p>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item d-none d-lg-block">

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdownsecondLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Asay Jurek Vintage home</a>
                  <div class="dropdown-menu dropdown-shadow navbar-dropdown-big rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownsecondLink">
                    <div class="row">
                      <div class="col-xl-4 col-lg-6">
                        <div class="row h-100">
                          <div class="col-4">
                            <img src="{{ asset('images/logo.jpg') }}" alt="logo" class="img-fluid">
                          </div>
                          <div class="col-12 d-flex flex-column justify-content-end">
                            <p class="font-weight-bolder h5">Мебель и аксессуары</p>
                            <a href="{{ route('product.all', ['p' => 57]) }}" class="text-decoration-none">Смотреть все товары</a>
                          </div>
                        </div>
                      </div>
                      <div class="col border-left d-flex align-items-center">
                        <div class="row pl-3" id="vintage-home">
                          <a href="{{ route('product.all', ['p' => 56, 'sex' => 'male']) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/male.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Мужчинам</p>
                          </a>
                          <a href="{{ route('product.all', ['p' => 56, 'sex' => 'female']) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/female.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Женщинам</p>
                          </a>
                          <a href="{{ route('product.all', ['p' => 56, 'sex' => 'children']) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/children.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="{{ route('product.all', ['p' => 56]) }}" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/clothes.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Одежда</p>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item d-none d-lg-block mr-lg-auto">
                <a href="{{ route('contacts') }}" class="nav-link text-dark">Адресс и контакты</a>
              </li>
{{--              Поиск--}}
<!--               <li class="nav-item d-none d-xl-flex">
                <form class="form-inline my-2 my-lg-0 nav-search" method="GET" action="{{ route('search') }}">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="nav-icon-search"><i class="far fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control h-100" id="nav-search" name="q" placeholder="Что вы искали?" required>
                  </div>
                  <button class="btn btn-orange ml-2"><i class="far fa-search"></i></button>
                </form>
              </li> -->
{{--              Поиск мобилка--}}
              <li class="nav-item dropdown d-flex ml-auto">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdowncurrencyLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-search icon-1_5x"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" style="min-width: 300px" aria-labelledby="dropdowncurrencyLink">
                  <form class="form-inline my-2 my-lg-0 nav-search" method="GET" action="{{ route('search') }}">
                    <div class="input-group w-100">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="nav-icon-search"><i class="far fa-search"></i></span>
                      </div>
                      <input type="text" class="form-control h-100 w-100 rounded-0" id="nav-search" name="q" placeholder="Что вы искали?" required>
                    </div>
                    <button type="submit" class="btn rounded-0 w-100 btn mt-2 bg-gray-50 text-white">Найти</button>
                  </form>
                </div>
              </li>

              <li class="nav-item dropdown ml-2 mr-md-2">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdowncurrencyLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="d-none d-lg-block">Валюта: {{ $currency->short_name }}</span>
                  <span class="d-block d-lg-none">{{ $currency->short_name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdowncurrencyLink">
                  @foreach(App\Models\Currency::all() as $cr)
                    <form action="{{ route('currency.change') }}" id="currency_{{$cr->id}}" method="POST">
                      @csrf
                      <input type="hidden" name="currency" value="{{$cr->id}}">
                      <a class="dropdown-item px-0 bg-transparent" href="#" onclick="$('#currency_{{$cr->id}}').submit()">{{$cr->name}}</a>
                    </form>
                  @endforeach
                </div>
              </li>
              @guest
                <li class="nav-item dropdown  px-1 px-md-3 border-md-left">
                  <a href="#" class="text-dark" role="button" id="dropdownuserLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-user icon-1_5x"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownuserLink">
                    <a class="dropdown-item px-0 bg-transparent d-flex align-items-center inverse" href="{{ route('login') }}">
                      <i class="icon-user icon-1_5x ml-0 mr-2"></i>
                      Войти
                    </a>
                    <a class="dropdown-item px-0 bg-transparent d-flex align-items-center inverse" href="{{ route('register') }}">
                      <i class="icon icon-log_out icon-1_5x ml-0 mr-2"></i>
                      Регистрация
                    </a>

                  </div>
                </li>
              @else
                <li class="nav-item dropdown  px-1 px-md-3 border-md-left">
                  <a href="#" class="text-dark" role="button" id="dropdownuserLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-user icon-1_5x"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownuserLink">
                    <a class="dropdown-item bg-transparent inverse" href="#">
                      <img src="{{ auth()->user()->getPhoto() }}" class="img-fluid rounded-circle mr-2" width="25px" height="25px" alt="avatar" style="object-fit: cover">
                      {{ auth()->user()->getIOName() }}
                    </a>
                    <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                      {{ csrf_field() }}
                    </form>
                    <a class="dropdown-item bg-transparent d-flex align-items-center inverse" href="#">
                      <i class="icon icon-list icon-1_5x ml-0 mr-2"></i>
                      Мои заказы
                    </a>
                    <a class="dropdown-item bg-transparent d-flex align-items-center inverse" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                      <i class="icon icon-log_out icon-1_5x ml-0 mr-2"></i>
                      Выйти
                    </a>

                  </div>
                </li>
              @endguest

              <li class="nav-item dropdown pl-md-3 pl-1 px-md-3 border-md-left">
                <a class="nav-link dropdown-toggle not-arrow text-dark" href="#" role="button" id="dropdowncartLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-cart icon-1_5x"></i></a>
                <div id="cart" class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdowncartLink">
                  @guest
                    <div class="row" v-for="item in $store.state.cart.items">
                      <div class="col-3 col-sm-2">
                        <img v-if="item.photos.length > 0" :src="'{{ asset('storage/items/') }}' + '/' + item.photos[0].name" :alt="item.title" class="img-fluid pb-2">
                        <img v-else :src="'{{ asset('images/unnamed.png') }}'" :alt="item.title" class="img-fluid pb-2">
                      </div>
                      <div class="col-9 col-sm-10 border-bottom">
                        <div class="row align-items-center h-100">
                          <div class="col-12 col-sm-6">
                            <p class="m-0">@{{ item.title }}</p>
                          </div>
                          <div class="col-auto ml-auto font-weight-bolder">
                            <p class="m-0">@{{ $cost((item.on_sale ? item.price_sale : item.price) * $store.state.currency.ratio ) }} @{{ $store.state.currency.symbol }}</p>
                          </div>
                          <div class="col-2">
                            <button type="button" @click="$store.commit('removeItem', item.id)" name="submit" class=" p-0 btn bg-transparent border-0 link"><i class="icon-trash icon-1_5x"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="mt-3 row align-items-center justify-content-between">
                      <div class="col-auto">
                        <p class="h5 font-weight-normal">Итого @{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</p>
                        <a href="javascript:;" class="text-decoration-none" @click="$store.commit('clearCart')">Очистить корзину</a>
                      </div>
                      <div class="col-auto">
                        <a href="#" class="btn btn-orange">Перейти в корзину</a>
                      </div>
                    </div>
                  @else
                    @foreach($cartItems as $ci)
                      <div class="row @if(!$loop->first) mt-2 @endif">
                        <div class="col-3 col-sm-2">
                          <img src="{{ $ci->placeholder() }}" alt="{{ $ci->title }}" class="img-fluid pb-2">
                        </div>
                        <div class="col-9 col-sm-10 border-bottom">
                          <div class="row align-items-center h-100">
                            <div class="col-12 col-sm-6">
                              <p class="m-0">{{ $ci->title }}</p>
                            </div>
                            <div class="col-auto ml-auto font-weight-bolder">
                              <p class="m-0">{{ $ci->cost($currency) }} {{ $currency->symbol }}</p>
                            </div>
                            <div class="col-2">
                              <form class="" action="{{ route('product.removeCart', $ci->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" name="submit" class=" p-0 btn bg-transparent border-0 link"><i class="icon-trash icon-1_5x"></i></button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                    <div class="mt-3 row align-items-center justify-content-between">
                      <div class="col-auto">
                        <p class="h5 font-weight-normal">Итого {{ $priceAmount }} {{ $currency->symbol }}</p>
                        <a href="#" class="text-decoration-none" onclick="event.preventDefault();document.getElementById('delete-all-items').submit();">Очистить корзину</a>
                        <form id="delete-all-items" class="d-none" action="{{ route('product.removeAll') }}" method="post">
                          @csrf
                        </form>
                      </div>
                      <div class="col-auto">
                        <a href="#" class="btn btn-orange">Перейти в корзину</a>
                      </div>
                    </div>
                  @endguest
                </div>
              </li>
            </ul>

          </div>
        </nav>
      </div>
    </div>

    <main class="py-4">
      @yield('content')
    </main>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    document.getElementById("cart").addEventListener('click', function (event) {
      event.stopPropagation();
    });

    $(window).resize(function () {
      $('#vintage-home .navbar-images-dropdown.scale').height($('#vintage-home .navbar-images-dropdown.scale').width())
      $('#clothes-and-acc .navbar-images-dropdown.scale').height($('#clothes-and-acc .navbar-images-dropdown.scale').width())
    })
    $('.dropdown-toggle').click(function () {
      setTimeout(() => {
        $('#vintage-home .navbar-images-dropdown.scale').height($('#vintage-home .navbar-images-dropdown.scale').width())
        $('#clothes-and-acc .navbar-images-dropdown.scale').height($('#clothes-and-acc .navbar-images-dropdown.scale').width())
      }, 100)
    })
  </script>
  @yield('js')
</body>
</html>
