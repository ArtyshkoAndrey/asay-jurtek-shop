<!doctype html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Admin</title>
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    @yield('css')
  </head>
  <body class="{{ Route::currentRouteNamed('admin.auth.login') || Route::currentRouteNamed('admin.auth.password.email') || Route::currentRouteNamed('admin.auth.password.reset') ? 'login-page' : '' }}">
    @if(Route::currentRouteNamed('admin.auth.login') || Route::currentRouteNamed('admin.auth.password.email') || Route::currentRouteNamed('admin.auth.password.reset'))
      @yield('content')
    @else
      <div class="wrapper">
        <div class="main-header ml-0">
          @include('admin.layouts.navbar')
        </div>
        <div class="sidebar-wrapper">
          @include('admin.layouts.aside')
        </div>
        <div class="content-wrapper">
          @yield('content')
        </div>
      </div>
    @endif
    <script src="{{ mix('js/admin.js') }}"></script>
    <script>
      $( document ).ready( () => {

        $(window).resize(() => {
          if ($(window).width() >= 992) {
           $('body').removeClass('sidebar-collapse');
          }
        });

        $('#name').click(() => {
          $('#list-auth').css('display', 'block')
        });
        $(document).click(function (event) {
          if (!$(event.target).closest('nav').length) {
            $('#list-auth').css('display', 'none')
          }
        })
      })
    </script>
  @yield('js')
  </body>
</html>
