<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index () {
    return view('admin.dashboard');
  }

  public function status (Request $request) {
    (new Setting)->statusSite((int)$request->has('status'));
    return redirect()->back();
  }
}
