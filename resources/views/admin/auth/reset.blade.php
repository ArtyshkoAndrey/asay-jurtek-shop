@extends('admin.layouts.app')
@section('title', 'Востановление пароля')

@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="{{ route('root') }}"><b>WallRide</b> Store</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Сброс пароля</p> 

        <form action="{{ route('admin.auth.password.reset') }}" method="post">
          @csrf
          <input type="hidden" value="{{ $email }}" name="email">
          <input type="hidden" name="token" value="{{ $token }}">
         <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Пароль">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Повторить пароль">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Войти</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
