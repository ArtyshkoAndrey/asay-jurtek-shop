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

  public function __construct (CartService $cartService) {
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) {
      $currency = Helpers::currency();

      extract($this->cartService->get(), EXTR_REFS);
      view()->share('currency', $currency);
      view()->share('cartItems', $cartItems);
      view()->share('priceAmount', number_format($priceAmount * $currency->ratio, null, null, ' '));
      view()->share('amount', $amount);
      return $next($request);
    });
  }
}
