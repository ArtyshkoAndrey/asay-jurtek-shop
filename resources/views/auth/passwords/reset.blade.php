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
          <div class="card-body p-4">
            <div class="row">

              <div class="col-12 mt-3">
                <form action="{{ route('password.update') }}" method="post">
                  @csrf
                  <input type="hidden" name="token" value="{{ $token }}">
                  <div class="form-group input-group rounded-0 @error('email') is-invalid @enderror">
                    <div class="input-group-prepend bg-white rounded-0">
                      <span class="input-group-text rounded-0  bg-white" id="nav-icon-search"><i class="fal fa-at"></i></span>
                    </div>
                    <label for="email" class="font-weight-bolder d-none">Email</label>
                    <input type="email" class="form-control rounded-0 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ $email ?? old('email') }}" required>
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

                  <button class="btn rounded-0 text-white bg-gray-50 d-block mt-3 ml-auto">Сменить пароль</button>
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
