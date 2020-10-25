<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
//    $this->middleware('auth');
  }

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
    return view('index', compact('header'));
  }
}
