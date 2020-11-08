<!-- Main Sidebar Container -->
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
          <a href="{{ route('admin.production.products.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.production.*') ? 'active' : '' }}">
            <i class="fas fa-cube mr-3"></i>
            <p>
              Товары
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.users.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-user mr-3"></i>
            <p>
              Пользователи
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ Route::currentRouteNamed('admin.setting.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="fas fa-cog mr-3"></i>
            <p>Настройки</p>
            <i class="fas fa-angle-left right"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.setting.menu-categories.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.setting.menu-categories.*') || Route::currentRouteNamed('admin.setting.link-menu.*') ? 'active' : '' }}">
                <i class="fal fa-bars mr-3"></i>
                <p>
                  Настройки меню
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.setting.first-sector.index') }}" class="nav-link rounded-0 {{ Route::currentRouteNamed('admin.setting.first-sector.*') ? 'active' : '' }}">
                <i class="far fa-image mr-3"></i>
                <p>
                  Сектор на полный экран
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
