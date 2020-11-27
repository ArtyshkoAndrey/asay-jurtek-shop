<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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

    $newses = News::all();
    return view('index', compact('header', 'items', 'secondSections', 'newses'));
  }

  /**
   * Display Contact page
   * @return Application|Factory|View
   */
  public function contacts(): View
  {
    return view('contacts');
  }

  /**
   * Display Reception page
   * @return Application|Factory|View
   */
  public function reception(): View
  {
    return view('reception');
  }

  /**
   * Return auth or not
   * @return JsonResponse
   */
  public function auth (): JsonResponse
  {
    return response()->json(['auth' => Auth::check()]);
  }
}
