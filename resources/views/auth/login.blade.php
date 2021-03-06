@extends('layouts.app')

@section('content')
  <div class="container-fluid d-flex align-items-center">
    <div class="row w-md-100 d-flex justify-content-center">
      <div class="col-lg-5 col-md-6 col-12">
        <div class="row justify-content-center">
          <div class="col-md-3 col-6">
            <img src="{{ asset('images/new-logo-selected.png') }}" alt="logo" class="img-fluid mb-5 mx-auto d-block">
          </div>
        </div>
        <div class="card rounded-0">
          <div class="row m-0 flex-nowrap text-center">
            <div class="col px-5 py-4 font-weight-bolder d-flex justify-content-center align-items-center"><i class="icon icon-user icon-1_5x color-orange "></i>Вход</div>
            <div class="col bg-gray px-4 px-md-5 py-4 link-inverse-login-register font-weight-bolder">
              <a href="{{ route('register') }}" class="text-decoration-none inverse d-flex justify-content-center align-items-center">
                <i class="icon icon-register icon-1_5x"></i>Регистрация</a>
            </div>
          </div>
          <div class="card-body p-4">
            <div class="row">
{{--              <div class="col-12">--}}
{{--                <h5 class="text-center w-100">Войдите черз соц сеть</h5>--}}
{{--              </div>--}}
{{--              <div class="col-12">--}}
{{--                <div class="row p-0 m-0">--}}
{{--                  <div class="col-4 p-0 pr-1">--}}
{{--                    <a href="#" class="btn d-block btn-outline-social rounded-0 d-flex justify-content-center h-100" id="google"><i class="icon icon-google"></i> <span class="d-none d-md-block">Google</span></a>--}}
{{--                  </div>--}}
{{--                  <div class="col-4 p-0 px-1">--}}
{{--                    <a href="#" class="btn d-block btn-outline-social rounded-0 d-flex justify-content-center h-100" id="fb"><i class="icon icon-facebook"></i> <span class="d-none d-md-block">Facebook</span></a>--}}
{{--                  </div>--}}
{{--                  <div class="col-4 p-0 pl-1">--}}
{{--                    <a href="#" class="btn d-block btn-outline-social rounded-0 d-flex justify-content-center align-items-center h-100" id="vk"><i class="fab fa-vk mr-md-1"></i> <span class="d-none d-md-block">VKontakte</span></a>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--              <div class="col-12 mt-3">--}}
{{--                <h5 class="text-center">Или укажите свой логин и пароль</h5>--}}
{{--              </div>--}}
              <div class="col-12 mt-3">
                <h5 class="text-center">Укажите свой логин и пароль</h5>
              </div>
              <div class="col-12 mt-3">
                <form action="{{ route('login') }}" method="post">
                  @csrf
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
                  <a href="{{ route('password.request') }}" class="text-decoration-none d-block">Забыли пароль?</a>

                  <button id="submitter" class="btn rounded-0 text-white btn-orange d-block mt-3 ml-auto" disabled>Войти</button>
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
    let checker = {
      password: false,
      email: false
    }
    $( "input" ).focus(function() {
      $(this).parent().addClass('focus')
    });
    $('input').focusout(function() {
      $(this).parent().removeClass('focus')
    });

    for (let key in checker) {
      $('#'+key).on('keydown keyup change', function () {
        let charLength = $(this).val().length;
        if (charLength > 3) {
          checker[key] = true
          console.log(disabled(checker))
          if(disabled(checker)) {
            $('#submitter').attr('disabled', false)
          } else {
            $('#submitter').attr('disabled', true)
          }
        }
      })
    }

    function disabled(checker) {
      let v = true
      for (let key in checker) {
        if (!checker[key]) {
          v = false
        }
      }
      return v
    }
  </script>
@endsection
