<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Zakaz - @yield('title')</title>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app" class="px-md-5 pt-4 px-0">

    <div class="container-fluid">
      <div class="row">
        <nav class="navbar navbar-light w-100 navbar-expand bg-transparent">
          <a class="navbar-brand h-100" href="{{ url('/') }}"><img src="{{ asset('images/logo.jpg') }}" alt="logo" class="h-100 w-auto"></a>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item d-none d-md-block">

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownfirstLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clothes and accessories</a>
                  <div class="dropdown-menu navbar-dropdown-big rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownfirstLink">
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
                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item d-none d-md-block">

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownsecondLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Asay Jurek Vintage home</a>
                  <div class="dropdown-menu navbar-dropdown-big rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownsecondLink">
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
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
          </div>
        </nav>
      </div>
    </div>

    <main class="py-4">
      @yield('content')
    </main>
  </div>
</body>
</html>
