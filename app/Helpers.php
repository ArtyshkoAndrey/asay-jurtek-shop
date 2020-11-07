<?php

namespace App;

use App\Models\Order;
use Carbon\Carbon;
use App\Models\Currency;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Paybox\Pay\Facade as Paybox;
use function PHPUnit\Framework\throwException;
use App\Models\Pay;

class Helpers
{
  public static function shout(string $string)
  {
    return strtoupper($string);
  }

  public static function currency () {
    $currency = null;
    if (Auth::check()) {
      if (auth()->user()->currency !== null) {
        $currency = Currency::find(auth()->user()->currency->id);
      } else {
        $currency = Currency::find(1);
      }
    } else {
      if (isset($_COOKIE['cr'])) {
        $currency = Currency::find($_COOKIE['cr']);
      } else {
        setcookie('cr', 1, time() + (3600 * 24 * 30), '/');
        $currency = Currency::find(1);
      }
    }
    if ($currency) {
      if (Carbon::parse($currency->updated_at)->addDay() < Carbon::now()) {
        $currency = Helpers::updateCurrency($currency);
      } else {
        null;
      }
    }
    return $currency;
  }

  public static function changeCurrency ($id) {
    if (Auth::check()) {
      $user = auth()->user();
      $user->currency_id = $id;
      $user->save();
    } else {
      setcookie('cr', $id, time() + (3600 * 24 * 30), '/');
    }
  }

  public static function route_class()
  {
    return str_replace('.', '-', Route::currentRouteName());
  }

  public static function updateCurrency (Currency $cr) {
    $assertion_link = 'https://nationalbank.kz/rss/rates_all.xml';
    $arrContextOptions=array(
      "ssl"=> array(
        "verify_peer" => false,
        "verify_peer_name" => false
      )
    );
    try {
      $assertion = file_get_contents($assertion_link, false, stream_context_create($arrContextOptions));
      $ar = simplexml_load_string($assertion);
      $currency = null;
      foreach ($ar->channel->item as $item) {
        if ((string)$item->title === 'USD') {
          $currency = Currency::where('name', 'Американский доллар')->first();
          $currency->ratio = 1 / $item->description;
          $currency->save();
        } else if ((string)$item->title === 'RUB') {
          $currency = Currency::where('name', 'Российский рубль')->first();
          $currency->ratio = 1 / $item->description;
          $currency->save();
        }
        $currency ? ($currency->id === $cr->id ? $cr = $currency : null) : null;
      }
      $currency = Currency::where('name', 'Тенге')->first();
      $currency->updated_at = Carbon::now();
      $currency->save();
      $currency ? ($currency->id === $cr->id ? $cr = $currency : null) : null;
    } catch (\ErrorException $e) {
      Log::info($e);
    }
    return $cr;
  }

  public static function paginate(Collection $results, $total, $pageSize)
  {
    $page = Paginator::resolveCurrentPage('page');

    try {
      return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
        'path' => Paginator::resolveCurrentPath(),
        'pageName' => 'page',
      ]);
    } catch (BindingResolutionException $e) {
      return back()->withErrors(['error' => $e]);
    }

  }

  /**
   * Create a new length-aware paginator instance.
   *
   * @param Collection $items
   * @param int $total
   * @param int $perPage
   * @param int $currentPage
   * @param array $options
   * @return LengthAwarePaginator
   * @throws BindingResolutionException
   */
  protected static function paginator($items, $total, $perPage, $currentPage, $options)
  {
    return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
      'items', 'total', 'perPage', 'currentPage', 'options'
    ));
  }

  public static function updateOrders () {
    $pay = Pay::first();
    $user = auth()->user();
    $paybox = new Paybox();
    $paybox->getMerchant()
      ->setId($pay->pg_merchant_id)
      ->setSecretKey($pay->code);
    $orders = $user->orders()->where('ship_status', Order::SHIP_STATUS_PAID)->get();
    ob_start ();
    foreach ($orders as $order) {
      $paybox->order->id = $order->id;
      $paymentStatus = $paybox->getStatus(); //partial/pending/ok/failed/revoked/incomplete
      if (!!$paymentStatus) {
        switch ($paymentStatus) {
          case 'ok':
            $order->ship_status = Order::SHIP_STATUS_PENDING;
            $order->save();
            break;
          case 'failed':
            $order->close();
            break;
        }
      } else {
        $order->close();
      }
    }
    ob_get_clean ();

  }

  public static function cost(int $num): string
  {
    return number_format($num, null, null, ' ');
  }
}
