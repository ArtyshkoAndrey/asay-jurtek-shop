<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller {

  // TODO: Изменить ретурн phpdov

  /**
   * Filter items and display search page
   * @param Request $request 
   * @return type
   */
  public function index (Request $request) {
    $q = $request->q;
    $items = Product::where('title', 'LIKE', '%' . $q . '%')->get();
    return view('search', compact('items', 'q'));
  }
}
