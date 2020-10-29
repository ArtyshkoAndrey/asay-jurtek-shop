<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Product;
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

  public function productsCheck (Request $request) {
    $request->validate([
      'ids' => 'required|array',
      'ids.*' => 'integer'
    ]);
    $items = Product::findMany($request->ids);
    return response()->json(['items' => $items]);
  }
  public function city ($city, $country = null) {
    if ($country === null)
      $cities = City::whereLike('name', $city)->take(20)->get();
    else
      $cities = City::whereHas('country', function ($q) use($country) {
        $q->where('countries.id', $country);
      })->whereLike('name', $city)->take(20)->get();
    return ['items' => $cities];
  }

  public function country ($country) {
    $countries = Country::whereLike('name', $country)->get();
    return ['items' => $countries];
  }

}
