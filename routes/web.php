<?php
use Illuminate\Support\Facades\Route;

if ((new App\Models\Setting)->statusSite()) {
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
  Route::resource('/order', \App\Http\Controllers\OrderController::class)->except([
    'update', 'edit', 'show', 'destroy'
  ]);

  Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'orders'])->name('order.orders');
    Route::prefix('profile')->name('profile.')->group(function () {
      Route::get('/', [\App\Http\Controllers\ProfileController::class, 'index'])->name('index');
      Route::put('/', [\App\Http\Controllers\ProfileController::class, 'update'])->name('update');
      Route::put('/photo', [\App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('update.photo');
      Route::put('/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('update.password');
    });
  });


}

Auth::routes();

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

  Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('root');
  Route::put('status', [\App\Http\Controllers\Admin\DashboardController::class, 'status'])->name('root.status');
  Route::resource('/users', App\Http\Controllers\Admin\UserController::class)->except([
    'create', 'store', 'show'
  ]);
  Route::name('store.')->group(function () {

    Route::resource('order', App\Http\Controllers\Admin\OrderController::class)->except([
      'create', 'store', 'show'
    ]);
    Route::delete('/order/all', [App\Http\Controllers\Admin\OrderController::class,'collectionsDestroy'])->name('order.collectionsDestroy');

    Route::resource('express', App\Http\Controllers\Admin\ExpressController::class)->except([
      'show'
    ]);
    Route::put('/express/enabled/{id}', [App\Http\Controllers\Admin\ExpressController::class, 'enabled'])->name('express.enabled');

    Route::resource('express-zone', App\Http\Controllers\Admin\ExpressZoneController::class)->except([
      'index', 'show'
    ]);
    Route::post('/express-zone/{id}/destroy', [App\Http\Controllers\Admin\ExpressZoneController::class, 'destroyCity'])->name('express-zone.destroyCity');
    Route::put('/express/set-city/{id}', [App\Http\Controllers\Admin\ExpressZoneController::class, 'setCity'])->name('express-zone.set-city');

    Route::resource('pay', App\Http\Controllers\Admin\PayController::class)->except([
      'create', 'store', 'show', 'destroy'
    ]);

    Route::resource('/report', App\Http\Controllers\Admin\ReportController::class);

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

    Route::resource('/skus', App\Http\Controllers\Admin\SkusController::class);

    Route::resource('/category', App\Http\Controllers\Admin\CategoryController::class);

  });

  Route::name('setting.')->prefix('setting')->group(function () {

    Route::get('/menu', [App\Http\Controllers\Admin\SettingController::class, 'menuIndex'])->name('menu.index');
    Route::put('/menu/{id}', [App\Http\Controllers\Admin\SettingController::class, 'menuUpdate'])->name('menu.update');

  });
});
