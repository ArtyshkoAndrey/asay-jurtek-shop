<div class="row mt-2" style="z-index: 100">
  <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2">
    <a href="{{ route('admin.production.products.index') }}" class="{{ Route::currentRouteNamed('admin.production.products.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Товары</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.production.category.index') }}" class="{{ Route::currentRouteNamed('admin.production.category.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Категории</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.production.brand.index') }}" class="{{ Route::currentRouteNamed('admin.production.brand.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Бренды</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.production.skus-category.index') }}" class="{{ Route::currentRouteNamed('admin.production.attr.*') || Route::currentRouteNamed('admin.production.skus-category.*')  ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Атрибуты</a>
  </div>
  <div class="col-sm-auto col-12 px-0 px-sm-2">
    <a href="{{ route('admin.production.promotions.index') }}" class="{{ Route::currentRouteNamed('admin.production.promotions.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Акции</a>
  </div>
</div>
