<?php
use Illuminate\Support\Facades\Route;

if ((new App\Models\Setting)->statusSite()) {

  // Auth::routes();
//   getAdminRoute();

// } else {
  Auth::routes();
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  getAdminRoute();
 }


function getAdminRoute() {
  Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('root');
    Route::put('status', [\App\Http\Controllers\Admin\DashboardController::class, 'status'])->name('root.status');
    Route::name('store.')->group(function () {
      Route::resource('order', App\Http\Controllers\Admin\OrderController::class);
      Route::delete('/order/all', [App\Http\Controllers\Admin\OrderController::class,'collectionsDestroy'])->name('order.collectionsDestroy');
    });
  });
}
