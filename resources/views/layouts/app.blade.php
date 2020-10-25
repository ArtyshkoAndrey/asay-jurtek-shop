<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Zakaz - @yield('title')</title>
  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/icon.css') }}">
  @yield('style')
</head>
<body>
  <div id="app" class="px-md-5 pt-1 px-0">

    <div class="container-fluid">
      <div class="row">
        <nav class="navbar navbar-light w-100 navbar-expand bg-transparent pt-0">
          <a class="navbar-brand h-100" href="{{ url('/') }}"><img src="{{ asset('images/logo.jpg') }}" alt="logo" class="h-100 w-auto"></a>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100">
              <li class="nav-item d-none d-md-block">

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdownfirstLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clothes and accessories</a>
                  <div class="dropdown-menu dropdown-shadow navbar-dropdown-big rounded-0 border-0 py-4 px-4" aria-labelledby="dropdownfirstLink" id="firstLink">
                    <div class="row">
                      <div class="col-xl-4 col-lg-6">
                        <div class="row">
                          <div class="col-4">
                            <img src="{{ asset('images/logo.jpg') }}" alt="logo" class="img-fluid">
                          </div>
                          <div class="col-12 mt-2">
                            <p class="font-weight-bolder h5">Одежда и аксессуары</p>
                            <a href="#" class="text-decoration-none">Смотреть все товары</a>
                          </div>
                        </div>
                      </div>
                      <div class="col border-left d-flex align-items-center">
                        <div class="row pl-3">
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item d-none d-md-block">

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdownsecondLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Asay Jurek Vintage home</a>
                  <div class="dropdown-menu dropdown-shadow navbar-dropdown-big rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownsecondLink">
                    <div class="row">
                      <div class="col-xl-4 col-lg-6">
                        <div class="row">
                          <div class="col-4">
                            <img src="{{ asset('images/logo.jpg') }}" alt="logo" class="img-fluid">
                          </div>
                          <div class="col-12 mt-2">
                            <p class="font-weight-bolder h5">Одежда и аксессуары</p>
                            <a href="#" class="text-decoration-none">Смотреть все товары</a>
                          </div>
                        </div>
                      </div>
                      <div class="col border-left d-flex align-items-center">
                        <div class="row pl-3">
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                          <a href="#" class="col text-decoration-none inverse">
                            <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid navbar-images-dropdown scale">
                            <p class="text-center m-0">Детям</p>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item d-none d-md-block mr-md-auto">
                <a href="#" class="nav-link text-dark">Адресс и контакты</a>
              </li>

              <li class="nav-item">
                <form class="form-inline my-2 my-lg-0 nav-search">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="nav-icon-search"><i class="far fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control h-100" id="nav-search" placeholder="Что вы искали?" required>
                  </div>
                </form>
              </li>

              <li class="nav-item dropdown ml-2 mr-2">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdowncurrencyLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Валюта: KZT</a>
                <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdowncurrencyLink">
                  <a class="dropdown-item bg-transparent" href="#">Казахстанский тенге</a>
                  <a class="dropdown-item border-top bg-transparent" href="#">Российский рубль</a>
                </div>
              </li>
              <li class="nav-item dropdown px-3 border-left">
                <a href="#" class="text-dark" role="button" id="dropdownuserLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-user icon-1_5x"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownuserLink">
                  <a class="dropdown-item bg-transparent inverse" href="#">
                    <img src="{{ asset('images/User icon loged.png') }}" class="img-fluid rounded mr-2" width="25px" alt="avatar">
                    Lorem ipsum dolor eiusmod
                  </a>
                  <a class="dropdown-item bg-transparent d-flex align-items-center inverse" href="#">
                    <i class="icon icon-list icon-1_5x ml-0 mr-2"></i>
                    Мои заказы
                  </a>
                  <a class="dropdown-item bg-transparent d-flex align-items-center inverse" href="#">
                    <i class="icon icon-log_out icon-1_5x ml-0 mr-2"></i>
                    Выйти
                  </a>

                </div>
              </li>
              <li class="nav-item dropdown pl-3 border-left">
                <a class="nav-link dropdown-toggle not-arrow text-dark" href="#" role="button" id="dropdowncartLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-cart icon-1_5x"></i></a>
                <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdowncartLink" style="min-width: 646px">

                  <div class="row">
                    <div class="col-2">
                      <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid pb-2">
                    </div>
                    <div class="col-10 border-bottom">
                      <div class="row align-items-center h-100">
                        <div class="col-6">
                          <p class="m-0">Рубашка от винтажного костюма Brandtex</p>
                        </div>
                        <div class="col-auto ml-auto font-weight-bold">
                          <p class="m-0">10 000 тг.</p>
                        </div>
                        <div class="col-2">
                          <form class="" action="#" method="post">
                            <button type="submit" name="submit" class="btn bg-transparent border-0 link"><i class="icon-trash icon-1_5x"></i></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-2">
                      <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid pb-2">
                    </div>
                    <div class="col-10 border-bottom">
                      <div class="row align-items-center h-100">
                        <div class="col-6">
                          <p class="m-0">Рубашка от винтажного костюма Brandtex</p>
                        </div>
                        <div class="col-auto ml-auto font-weight-bold">
                          <p class="m-0">10 000 тг.</p>
                        </div>
                        <div class="col-2">
                          <form class="" action="#" method="post">
                            <button type="submit" name="submit" class="btn bg-transparent border-0 link"><i class="icon-trash icon-1_5x"></i></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-2">
                      <img src="{{ asset('images/navbar-images.jpg') }}" alt="navbar-images" class="img-fluid pb-2">
                    </div>
                    <div class="col-10 border-bottom">
                      <div class="row align-items-center h-100">
                        <div class="col-6">
                          <p class="m-0">Рубашка от винтажного костюма Brandtex</p>
                        </div>
                        <div class="col-auto ml-auto font-weight-bold">
                          <p class="m-0">10 000 тг.</p>
                        </div>
                        <div class="col-2">
                          <form class="" action="#" method="post">
                            <button type="submit" name="submit" class="btn bg-transparent border-0 link"><i class="icon-trash icon-1_5x"></i></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mt-3 row align-items-center justify-content-between">
                    <div class="col-auto">
                      <p class="h5 font-weight-normal">Итого 57 000 тг.</p>
                      <a href="#" class="text-decoration-none">Очистить корзину</a>
                    </div>
                    <div class="col-auto">
                      <a href="#" class="btn btn-orange">Перейти в корзину</a>
                    </div>
                  </div>
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
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
