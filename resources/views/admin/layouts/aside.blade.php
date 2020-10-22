<!-- Main Sidebar Container -->
@auth('admin')
<aside class="main-sidebar sidebar-dark-primary" style="margin-top: 56px; min-height: calc(100vh - 56px); height: 100%; z-index: 1038">

  <!-- Sidebar -->
  <div class="sidebar p-0 mt-3">
    <!-- Sidebar Menu -->
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="{{ route('admin.root') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.root') ? 'active' : '' }}">
            <i class="fas fa-tachometer-slowest mr-3"></i>
            <p>
              Главная
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.store.order.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.store.*') ? 'active' : '' }}">
            <i class="fal fa-store mr-3"></i>
            <p>
              Магазин
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.currency.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.currency.*') ? 'active' : '' }}">
            <i class="fal fa-badge-dollar mr-3"></i>
            <p>
              Валюта
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.production.products.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.production.*') ? 'active' : '' }}">
            <i class="fas fa-cube mr-3"></i>
            <p>
              Товары
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.store.order.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.user.*') ? 'active' : '' }}">
            <i class="fas fa-user mr-3"></i>
            <p>
              Пользователи
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="{{ route('admin.news.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.news.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper mr-3"></i>
            <p>
              Новости
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ Route::currentRouteNamed('admin.header-mobile.*') || Route::currentRouteNamed('admin.header.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="fas fa-cog mr-3"></i>
            <p>Настройки</p>
            <i class="fas fa-angle-left right"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.header.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.header.*') ? 'active' : '' }}">
                <i class="fas fa-cog mr-3"></i>
                <p>
                  Настройки шапки
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('admin.header-mobile.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.header-mobile.*') ? 'active' : '' }}">
                <i class="fas fa-cog mr-3"></i>
                <p>
                  Настройки (mobile)
                </p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('telescope') }}" class="nav-link rounded-0">
            <i class="fal fa-debug mr-3"></i>
            <p>
              Telescope
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
@endauth
