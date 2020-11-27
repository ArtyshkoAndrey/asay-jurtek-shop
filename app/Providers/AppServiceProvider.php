<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
//    if ($this->app->isLocal()) {
//      $this->app->register(TelescopeServiceProvider::class);
//    }
    if ($this->app->isLocal()) {
      $this->app->register(IdeHelperServiceProvider::class);
    }
    $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
    $this->app->register(TelescopeServiceProvider::class);
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {

  }
}
