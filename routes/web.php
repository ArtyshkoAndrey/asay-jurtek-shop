<?php
use Illuminate\Support\Facades\Route;
//Route::get('/test', function () {
//  (new App\Models\Setting)->setHeader();
//});
if ((new App\Models\Setting)->statusSite()) {
  Auth::routes();

  Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
  Route::get('/contacts', [App\Http\Controllers\HomeController::class, 'contacts'])->name('contacts');
  Route::post('/currency/change', [App\Http\Controllers\CurrencyController::class, 'change'])->name('currency.change');
  Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
  Route::prefix('product')->name('product.')->group(function () {
    Route::get('/all', [\App\Http\Controllers\ProductController::class, 'all'])->name('all');
    Route::get('/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('show');
    Route::post('/all', [\App\Http\Controllers\ProductController::class, 'removeAllCart'])->name('removeAll');
    Route::post('/{id}', [\App\Http\Controllers\ProductController::class, 'addCart'])->name('addCart');
    Route::delete('/{id}', [\App\Http\Controllers\ProductController::class, 'removeCart'])->name('removeCart');
  });

    getAdminRoute();
 } else {
  Auth::routes();
  getAdminRoute();
 }


function getAdminRoute() {
  Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('root');
    Route::put('status', [\App\Http\Controllers\Admin\DashboardController::class, 'status'])->name('root.status');

    Route::name('store.')->group(function () {

      Route::resource('order', App\Http\Controllers\Admin\OrderController::class);
      Route::delete('/order/all', [App\Http\Controllers\Admin\OrderController::class,'collectionsDestroy'])->name('order.collectionsDestroy');

      Route::resource('express', App\Http\Controllers\Admin\ExpressController::class);
      Route::put('/express/enabled/{id}', [App\Http\Controllers\Admin\ExpressController::class, 'enabled'])->name('express.enabled');

      Route::resource('express-zone', App\Http\Controllers\Admin\ExpressZoneController::class);
      Route::post('/express-zone/{id}/destroy', [App\Http\Controllers\Admin\ExpressZoneController::class, 'destroyCity'])->name('express-zone.destroyCity');

      Route::resource('pay', App\Http\Controllers\Admin\PayController::class);



    });

    Route::name('production.')->group(function () {
      Route::name('products.')->prefix('products')->group(function () {
        Route::delete('/all', [App\Http\Controllers\Admin\ProductsController::class, 'collectionsDestroy'])->name('collectionsDestroy');
        Route::post('/all', [App\Http\Controllers\Admin\ProductsController::class, 'collectionsRestore'])->name('collectionsRestore');
        Route::post('/{id}/photo', [App\Http\Controllers\Admin\ProductsController::class, 'photo'])->name('photo');
        Route::post('/photo-create', [App\Http\Controllers\Admin\ProductsController::class, 'photoCreate'])->name('photoCreate');
        Route::post('/{id}/photo-delete', [App\Http\Controllers\Admin\ProductsController::class, 'photoDelete'])->name('photoDelete');
        Route::post('/photo-delete-create', [App\Http\Controllers\Admin\ProductsController::class, 'photoDeleteCreate'])->name('photoDeleteCreate');

      });
      Route::resource('/products', App\Http\Controllers\Admin\ProductsController::class);
      Route::resource('/attr', App\Http\Controllers\Admin\SkusController::class);
      Route::resource('/skus-category', App\Http\Controllers\Admin\SkusCategoriesController::class);
    });
  });
}
