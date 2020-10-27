<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller {

  public function show ($id) {
    $item = Product::with('photos')->find($id);
    $items = Product::take(4)->get(); // TODO: Сделать вывод из той же категории
    return view('item', compact('item', 'items'));
  }
}
