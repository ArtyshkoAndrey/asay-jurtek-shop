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
  <body class="">
    <div class="wrapper">
      <div class="main-header ml-0">
        @include('admin.layouts.navbar')
      </div>
      <div class="sidebar-wrapper">
        @include('admin.layouts.aside')
      </div>
      <div class="content-wrapper">
        @if (session()->has('success'))
          @foreach (session('success') as $message)
            <div class="alert alert-info alert-dismissible position-absolute rounded-0 mt-3 mr-3" style="z-index: 100; right: 0;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-info"></i> Уcпешно</h4>
              {{ $message }}
              {{-- Lorem ipsum dolor sit amet. --}}
            </div>
          @endforeach
        @endif
        @yield('content')
      </div>
    </div>
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
