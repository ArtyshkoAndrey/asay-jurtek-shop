<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class HomeController.
 * Класс для обычных страниц
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

  /**
   * Get settings and display Index page
   *
   * @return Application|Factory|View
   */
  public function index(): View
  {
    $headerTemp = Setting::where('key', 'header')->first();
    $header = $headerTemp->meta;
    $secondSections = Setting::where('key', 'second-section')->get();
    $items = Product::where('on_new', true)
      ->orderBy('created_at', 'desc')
      ->take(4)
      ->with('photos')
      ->get();
    return view('index', compact('header', 'items', 'secondSections'));
  }

  /**
   * Display Contact page
   * @return Application|Factory|View
   */
  public function contacts(): View
  {
    return view('contacts');
  }
}
