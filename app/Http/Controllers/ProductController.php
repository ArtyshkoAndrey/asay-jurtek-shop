<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller {

  protected $cartService;

  public function __construct(CartService $cartService)
  {
    parent::__construct($cartService);
  }
  public function show ($id, Request $request) {
    $item = Product::with('photos')->find($id);
    $inCart = false;
    if ($user = $request->user()) {
      $inCart = (bool) $user->cartItems()->where('product_id', $id)->first();
    }
    $items = Product::take(4)->get(); // TODO: Сделать вывод из той же категории
    return view('item', compact('item', 'items', 'inCart'));
  }

  public function addCart ($id) {
    if(Auth::check()) {
      $this->cartService->add($id);
      return redirect()->back();
    }
  }

  public function removeCart ($id) {
    if(Auth::check()) {
      $this->cartService->remove($id);
      return redirect()->back();
    }
  }

  public function removeAllCart () {
    dd(123);
    if(Auth::check()) {
      $this->cartService->deleteAll();

      return redirect()->back();
    }
  }
}
