<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Services\CartService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller. Контроллер, принимает CartService и в шаблоны раздаёт
 * валюту, корзину, общую стоимость, и кол-во товаров
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Var for shared user data
   * @var CartService
   */
  protected $cartService;

  /**
   * construct, shared vars in views
   *
   * @param CartService $cartService
   */
  public function __construct (CartService $cartService) {
    $this->cartService = $cartService;
    $this->middleware(function ($request, $next) {
      if (auth()->check())
        Helpers::updateOrders();
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
