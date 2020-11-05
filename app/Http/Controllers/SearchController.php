<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Class SearchController.
 * Контроллер для работы с поиском
 *
 * @package App\Http\Controllers
 */
class SearchController extends Controller {

  /**
   * Filter items and display search page
   * @param Request $request
   * @return Application|Factory|View
   */
  public function index (Request $request): View
  {
    $request->validate([
      'q' => 'required|string'
    ]);
    $data = $request->all();
    $q = $data['q'];
    $items = Product::where('title', 'LIKE', '%' . $q . '%')->get();
    return view('search', compact('items', 'q'));
  }
}
