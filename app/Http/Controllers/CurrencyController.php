<?php

namespace App\Http\Controllers;

use App\Helpers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class CurrencyController.
 * Класс для работы с валютой
 *
 * @package App\Http\Controllers
 */
class CurrencyController extends Controller
{

  /**
   * function for change currency User
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function change(Request $request):RedirectResponse
  {
    $request->validate([
      'currency' => 'required|exists:App\Models\Currency,id'
    ]);
    $data = $request->all();
    Helpers::changeCurrency($data['currency']);
    return redirect()->back();
  }
}
