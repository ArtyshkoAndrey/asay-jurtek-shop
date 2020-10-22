<div class="row mt-2" style="z-index: 100">
  <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2">
    <a href="{{ route('admin.store.order.index') }}" class="{{ Route::currentRouteNamed('admin.store.order.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Заказы</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.store.coupon.index') }}" class="{{ Route::currentRouteNamed('admin.store.coupon.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Промокоды</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.store.express.index') }}" class="{{ Route::currentRouteNamed('admin.store.express.*') || Route::currentRouteNamed('admin.store.express-zone.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Доставка</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.store.pay.index') }}" class="{{ Route::currentRouteNamed('admin.store.pay.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Оплата</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.store.reports.index') }}" class="{{ Route::currentRouteNamed('admin.store.reports.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Отчеты</a>
  </div>
  <div class="col-sm-auto col-6 px-0 px-sm-2">
    <a href="{{ route('admin.store.stock.index') }}" class="{{ Route::currentRouteNamed('admin.store.stock.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">Акции</a>
  </div>
  <div class="col-sm-auto col-12 px-0 px-sm-2">
    <a href="{{ route('admin.store.faqs.index') }}" class="{{ Route::currentRouteNamed('admin.store.faqs.*') ? 'bg-white' : 'bg-dark' }} px-3 py-2 d-block">FAQ</a>
  </div>
</div>
