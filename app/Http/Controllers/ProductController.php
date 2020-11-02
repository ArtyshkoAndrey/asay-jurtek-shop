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
    if(Auth::check()) {
      $this->cartService->deleteAll();

      return redirect()->back();
    }
  }

  public function all (Request $request) {
    $items = Product::query();
    if ($sex = $request->input('sex', null)) {
      if (in_array($sex, Product::SEX_ATTR_MAP)) {
        $items = $items->where('sex', $sex);
      }
    }

    if ($category = $request->input('category', null)) {
      $items = $items->whereHas('categories', function ($query) use ($category) {
        $query->whereHas('parents', function ($query) use ($category) {
          $query->where('laravel_reserved_0.id', $category);
        })->orWhere('categories.id', $category);
      });
    }

    if ($brand = $request->input('brand', null)) {
      $items = $items->whereHas('brands', function ($query) use ($brand) {
        return $query->where('brands.id', $brand);
      });
    }

    if ($size = $request->input('size', null)) {
      $items = $items->whereHas('skus', function ($query) use ($size) {
        $query->where('skuses.id', $size);
      });
    }
    $items = $items->get();
    $filter = ['sex' => $sex, 'category' => $category, 'size' => $size, 'brand' => $brand];
    return view('all', compact('items', 'filter'));
    dd($items->get());
  }
}
