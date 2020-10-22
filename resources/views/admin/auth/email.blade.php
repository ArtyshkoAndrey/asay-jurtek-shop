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
        <p class="login-box-msg">Востановление пароля</p>

        <form action="{{ route('admin.auth.password.email') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Востановить</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
