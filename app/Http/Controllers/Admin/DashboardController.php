<?php
/*
 * Copyright (c) 2020.
 * The written code is completely free, full copying and modifications for improvement are allowed.
 * I am Fulliton https://github.com/ArtyshkoAndrey giving the right to everyone, without exception, to use this code.
 * Stable and optimized code =)
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * Class for index page in admin panel
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
  /**
   * Display index page
   * @return Application|Factory|View
   */
  public function index (): View
  {
    return view('admin.dashboard');
  }

  /**
   * Set status site
   * @param Request $request
   * @return RedirectResponse
   */
  public function status (Request $request) {
    Setting::setStatusSite((bool) $request->has('status'));
    return redirect()->back();
  }
}
