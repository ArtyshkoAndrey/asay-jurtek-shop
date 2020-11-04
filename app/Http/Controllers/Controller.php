<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Services\CartService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
  protected $cartService;

  /**
   * Contructor, shared vars in views
   * 
   * @param CartService $cartService 
   * @return type
   */
  public function __construct (CartService $cartService) {
    $this
      ->cartService = $cartService;
      ->middleware(function ($request, $next) {
        $currency = Helpers::currency();
        $cartItems = [];
        $amount = 0;
        $priceAmount = 0;
        auth()->user() ? extract($this->cartService->get(), EXTR_REFS) : null;
        view()->share('currency', $currency);
        view()->share('cartItems', $cartItems);
        view()->share('priceAmount', number_format($priceAmount * $currency->ratio, null, null, ' '));
        view()->share('amount', $amount);
        return $next($request);
      });
  }
}
