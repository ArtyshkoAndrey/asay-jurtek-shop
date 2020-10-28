<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Currency;
use Illuminate\Http\Request;

class ApiController extends Controller
{
  public function __constructor()
  {
    //
  }

  public function getCurrency ($id) {
    $currency = Currency::find($id);
    return response()->json(['currency' => $currency]);
  }
}
