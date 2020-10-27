<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class SearchController extends Controller {

  public function index (Request $request) {
    $q = $request->q;
    $items = Product::where('title', 'LIKE', '%' . $q . '%')->get();
    return view('search', compact('items', 'q'));
  }
}
