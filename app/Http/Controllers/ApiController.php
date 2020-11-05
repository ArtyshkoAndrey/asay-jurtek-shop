<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ApiController. Класс который помогает делать часть
 * задач без перезагрузки страницы
 *
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{

  /**
   * function for get currency by id
   *
   * @param int $id
   * @return JsonResponse
   */
  public function getCurrency (int $id): JsonResponse
  {
    $currency = Currency::find($id);
    return response()->json(['currency' => $currency]);
  }

  /**
   * Check actual items by ids
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function productsCheck (Request $request): JsonResponse
  {
    $request->validate([
      'ids' => 'required|array',
      'ids.*' => 'integer'
    ]);
    $data = $request->all();
    $items = Product::findMany($data['ids']);
    return response()->json(['items' => $items]);
  }

  /**
   * get cities by filter name or get cities in country
   *
   * @param string $city
   * @param int|null $country
   * @return JsonResponse
   */
  public function city (string $city, int $country = null): JsonResponse
  {
    if ($country === null)
      $cities = City::whereLike('name', $city)->take(20)->get();
    else
      $cities = City::whereHas('country', function ($q) use($country) {
          $q->where('countries.id', $country);
        })
        ->whereLike('name', $city)->take(20)->get();
    return response()->json(['items' => $cities]);
  }

  /**
   * get countries by filter name
   *
   * @param string $country
   * @return JsonResponse
   */
  public function country (string $country): JsonResponse
  {
    $countries = Country::whereLike('name', $country)->get();
    return response()->json(['items' => $countries]);
  }

  /**
   * get categories by filter name
   *
   * @param string $category
   * @return JsonResponse
   */
  public function category (string $category): JsonResponse
  {
    $categories = Category::whereLike('name', $category)->get();
    return response()->json(['items' => $categories]);
  }

  /**
   * get brands by filters name
   *
   * @param string $brand
   * @return JsonResponse
   */
  public function brand (string $brand): JsonResponse
  {
    $brands = Brand::whereLike('name', $brand)->get();
    return response()->json(['items' => $brands]);
  }

  /**
   * Function for filtered Express companies
   *
   * @param Request $request
   * @return array
   */
  public function companies(Request $request): array
  {
    $request->validate([
      'city' => 'required|integer',
    ]);

    $data = $request->all();
    $express_companies = ExpressCompany::where('name', '!=', 'Самовывоз')->get();
    $zones = ExpressZone::with('company')
      ->whereHas('cities', function ($qq) use ($data) {
        $qq->where('cities.id', $data['city']);
      })
      ->get();
    $express_companies = $express_companies->toArray();

//    Перебираем все компании
    for($i=0;$i<count($express_companies); $i++) {
//      Перебираем все зоны которые есть в данном городе
      foreach ($zones as $z) {
//        Если id компании у зоны равен у компании
        if($z->company->id === $express_companies[$i]['id']) {
//          Проверка тип стоимости у зоны, масов шагов или цена за определённый шаг
          if ($z->step_cost_array !== null) { // цена - массив шагов
            $express_companies[$i]['costedTransfer'] = $z->step_cost_array; // Цена - масив шагов
            $express_companies[$i]['step_unlim'] = null;
            $express_companies[$i]['step_cost_unlim'] = null;
          } else {
            $express_companies[$i]['costedTransfer'] = $z->cost; // Цена фиксированная за 0.5 кг
            $express_companies[$i]['step_unlim'] = $z->step; // Шаг для перевеса после 0.5 кг
            $express_companies[$i]['step_cost_unlim'] = $z->cost_step; // Цена шага после перевеса
          }
        }
      }
//      Проверка на несуществование таких полей
//      Задаём всё нулл что бы были одинаковые обьекты
      if (!isset($express_companies[$i]['costedTransfer'])) {
        $express_companies[$i]['costedTransfer'] = null;
        $express_companies[$i]['step_unlim'] = null;
        $express_companies[$i]['step_cost_unlim'] = null;
      }
    }
    return $express_companies;
  }

}
