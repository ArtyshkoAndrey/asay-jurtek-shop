<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

  // TODO: Ретурн тип изменить

  /**
   * Override contructor
   * @return type
   */
  public function __constructor()
  {
    //
  }

  // TODO: Ретурн тип изменить, в функции изменить тип

  /**
   * function for change currency User
   * 
   * @param Request $request 
   * @return Response
   */
  public function change(Request $request) {
    Helpers::changeCurrency($request->currency);
    return redirect()->back();
  }
}
