@extends('layouts.app')

@section('content')
  <div class="container-fluid d-flex align-items-center">
    <div class="row w-md-100 d-flex justify-content-center">
      <div class="col-lg-5 col-md-6 col-12">
        <div class="row justify-content-center">
          <div class="col-md-3 col-6">
            <img src="{{ asset('images/new-logo.png') }}" alt="logo" class="img-fluid mb-5 mx-auto d-block">
          </div>
        </div>
        <div class="card rounded-0">
          <div class="row m-0 flex-nowrap text-center">
            <div class="col bg-gray px-4 px-md-5 py-4 link-inverse-login-register font-weight-bolder">
              <a href="{{ route('login') }}" class="text-decoration-none inverse d-flex justify-content-center align-items-center"><i class="icon icon-user icon-1_5x"></i>Войти</a>
            </div>
            <div class="col px-5 py-4 font-weight-bolder d-flex justify-content-center align-items-center"><i class="icon icon-register icon-1_5x color-orange "></i>Регистрация</div>
          </div>
          <div class="card-body p-4">
            <div class="row">
              <div class="col-12">
                <h5 class="text-center w-100">Регистрация черз соц сеть</h5>
              </div>
              <div class="col-12">
                <div class="row p-0 m-0">
                  <div class="col-4 p-0 pr-1">
                    <a href="#" class="btn d-block btn-outline-social rounded-0 d-flex justify-content-center h-100" id="google"><i class="icon icon-google"></i> <span class="d-none d-md-block">Google</span></a>
                  </div>
                  <div class="col-4 p-0 px-1">
                    <a href="#" class="btn d-block btn-outline-social rounded-0 d-flex justify-content-center h-100" id="fb"><i class="icon icon-facebook"></i> <span class="d-none d-md-block">Facebook</span></a>
                  </div>
                  <div class="col-4 p-0 pl-1">
                    <a href="#" class="btn d-block btn-outline-social rounded-0 d-flex justify-content-center align-items-center h-100" id="vk"><i class="fab fa-vk mr-md-1"></i> <span class="d-none d-md-block">VKontakte</span></a>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-3">
                <h5 class="text-center">Или укажите логин и пароль</h5>
              </div>
              <div class="col-12 mt-3">
                <form action="{{ route('register') }}" method="post">
                  @csrf
                  <div class="form-group input-group rounded-0 @error('first_name') is-invalid @enderror">
                    <div class="input-group-prepend bg-white rounded-0">
                      <span class="input-group-text rounded-0  bg-white" id="nav-icon-search"><i class="icon-user"></i></span>
                    </div>
                    <label for="first_name" class="font-weight-bolder d-none">first_name</label>
                    <input type="text" class="form-control rounded-0 @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="Имя" value="{{ old('first_name') }}" required>
                    @error('first_name')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group input-group rounded-0 @error('last_name') is-invalid @enderror">
                    <div class="input-group-prepend bg-white rounded-0">
                      <span class="input-group-text rounded-0  bg-white" id="nav-icon-search"><i class="icon-user"></i></span>
                    </div>
                    <label for="second_name" class="font-weight-bolder d-none">last_name</label>
                    <input type="text" class="form-control rounded-0 @error('second_name') is-invalid @enderror" id="second_name" name="second_name" placeholder="Фамия" value="{{ old('second_name') }}" required>
                    @error('second_name')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group input-group rounded-0 @error('email') is-invalid @enderror">
                    <div class="input-group-prepend bg-white rounded-0">
                      <span class="input-group-text rounded-0  bg-white" id="nav-icon-search"><i class="fal fa-at"></i></span>
                    </div>
                    <label for="email" class="font-weight-bolder d-none">Email</label>
                    <input type="email" class="form-control rounded-0 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group input-group @error('password') is-invalid @enderror">
                    <label for="password" class="font-weight-bolder d-none">Пароль</label>
                    <div class="input-group-prepend bg-white">
                      <span class="input-group-text bg-white" id="nav-icon-search"><i class="far fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control rounded-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Пароль" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group input-group">
                    <label for="password_confirmation" class="font-weight-bolder d-none">Повторите пароль</label>
                    <div class="input-group-prepend bg-white">
                      <span class="input-group-text bg-white" id="nav-icon-search"><i class="far fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control rounded-0" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required>
                  </div>

                  <button class="btn rounded-0 text-white bg-gray-50 d-block mt-3 ml-auto">Зарегистрироваться</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $( "input" ).focus(function() {
      $(this).parent().addClass('focus')
    });
    $('input').focusout(function() {
      $(this).parent().removeClass('focus')
    });
  </script>
@endsection
