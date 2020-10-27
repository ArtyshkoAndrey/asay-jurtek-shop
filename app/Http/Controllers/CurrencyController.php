<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
  public function __constructor()
  {
//
  }

  public function change(Request $request) {
    Helpers::changeCurrency($request->currency);
    return redirect()->back();
  }
}
