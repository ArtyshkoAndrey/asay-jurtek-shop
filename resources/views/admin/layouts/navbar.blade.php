<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-dark navbar-light ml-0 border-0" style="height: 56px; background: #000;">
  <!-- Right navbar links -->
  <ul class="navbar-nav d-lg-none">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <ul class="navbar-nav w-100">
    <li class="nav-item row ml-auto mr-auto">
      <img src="{{ asset('public/images/new-logo-selected.png') }}" height="40" alt="">
    </li>
    <li class="nav-item dropdown row">
      <section class="col">
        <a class="row nav-link p-0 h-auto" id="name" style="cursor: pointer" role="button">{{ auth()->user()->getFSName() }}</a>
        <div class="row">
          <a href="{{ route('admin.users.edit', auth()->user()->id) }}" style="font-size: 12px; color: #F33C3C; line-height: 12px; z-index: 1000">
            настройки пользователя
          </a>
        </div>
      </section>
      <section class="col-auto"><img src="{{ auth()->user()->getPhoto() }}" class="rounded-circle w-auto" height="40" alt="person"></section>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="list-auth">
        <a class="dropdown-item" href="{{ route('logout') }}">Выход</a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
