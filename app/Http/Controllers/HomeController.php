<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function home()
  {
    return view('home');
  }

  public function index() {
    $headerTemp = Setting::where('key', 'header')->first();
    $header = json_decode($headerTemp->meta);
    $items = Product::where('on_new', true)->orderBy('created_at', 'desc')->take(4)->with('photos')->get();
    return view('index', compact('header', 'items'));
  }
}
