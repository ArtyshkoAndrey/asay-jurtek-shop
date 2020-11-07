<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Category;

class SettingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function menuIndex(Request $request)
  {
    $setting = Setting::where('key', 'menu')->first();
    $categories = Category::all();
    return view('admin.setting.menu', compact('setting', 'categories'));
  }

  public function menuUpdate(Request $request, Setting $setting) {
    dd($request->all());
  }


}
