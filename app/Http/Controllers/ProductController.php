<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller {
  /**
   * @var CartService $cartService
   */
  protected $cartService;


  /**
   * ProductController constructor.
   * @param CartService $cartService
   */
  public function __construct(CartService $cartService)
  {
    parent::__construct($cartService);
  }


  /**
   * displays the selected product
   *
   * @param int $id
   * @param Request $request
   * @return View
   */
  public function show (int $id, Request $request): view
  {
    $item = Product::with('photos')->find($id);
    $inCart = false;
    if ($user = $request->user()) {
      $inCart = (bool) $user->cartItems()->where('product_id', $id)->first();
    }
    $items = Product::take(4)->get(); // TODO: Сделать вывод из той же категории
    return view('item', compact('item', 'items', 'inCart'));
  }

  /**
   * adds one item to the cart
   *
   * @param int $id
   * @return RedirectResponse
   * @throws InvalidRequestException
   */
  public function addCart (int $id): RedirectResponse
  {
    if(Auth::check()) {
      $this->cartService->add($id);
      return redirect()->back();
    }
    return redirect()->back()->withErrors(['auth' => 'Вы не авторизированы']);
  }

  /**
   * removes one item from the cart for authorized users
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function removeCart (int $id): RedirectResponse
  {
    if(Auth::check()) {
      $this->cartService->remove($id);
      return redirect()->back();
    }
    return redirect()->back()->withErrors(['auth' => 'Вы не авторизированы']);
  }

  /**
   * removes items from the cart for authorized users
   *
   * @return RedirectResponse
   */
  public function removeAllCart (): RedirectResponse
  {
    if(Auth::check()) {
      $this->cartService->deleteAll();

      return redirect()->back();
    }
  }

  /**
   * display of all products by filter
   *
   * @param Request $request
   * @return Application|Factory|View
   */
  public function all (Request $request): view
  {
    $items = Product::query();
    $order = $request->input('order', 'sort-new');
    $parentCategory = (int) $request->input('p', null);

    if ($order) {
      if ($order === 'sort-new') {
        $items = $items->orderBy('created_at', 'desc');
      } else if ($order === 'sort-old') {
        $items = $items->orderBy('created_at', 'asc');
      } else if ($order === 'sort-expensive') {
        $items = $items->orderBy('price', 'desc');
      } else if ($order === 'sort-cheap') {
        $items = $items->orderBy('price', 'asc');
      }
    }

    if ($parentCategory) {
      $items = $items->whereHas('categories', function ($query) use ($parentCategory) {
        return $query->whereHas('parents', function ($query) use ($parentCategory) {
          return $query->where('laravel_reserved_0.id', '=', $parentCategory);
        });
      });
    }

    if ($categoryArr = $request->input('category', [])) {
      foreach ($categoryArr as $index => $category) {
        if ($index == 0) {
          $items = $items->whereHas('categories', function ($query) use ($category) {
            return $query->where('categories.id', '=', $category);
          });
        } else {
          $items = $items->orWhereHas('categories', function ($query) use ($category) {
            return $query->where('categories.id', '=', $category);
          });
        }
      }
    }

    if ($sizeArr = $request->input('skus', [])) {
      foreach ($sizeArr as $index => $size) {
        if ($index == 0) {
          $items = $items->whereHas('skus', function ($query) use ($size) {
            return $query->where('id', '=', $size);
          });
        } else {
          $items = $items->orWhereHas('skus', function ($query) use ($size) {
            return $query->where('id', '=', $size);
          });
        }
      }
    }

    if ($sexArr = $request->input('sex', [])) {
      foreach ($sexArr as $index => $sex) {
        if (in_array($sex, Product::SEX_ATTR_MAP)) {
          $items = $index == 0 ? $items->where('sex', '=', $sex) : $items->orWhere('sex', '=', $sex);
        }
      }
    }

    $items = $items->paginate(20);
    $filter = [
      'sex' => $sexArr,
      'category' => $categoryArr,
      'size' => $sizeArr,
      'p' => $parentCategory,
      'order' => $order
    ];
    return view('all', compact('items', 'filter'));
  }
}
