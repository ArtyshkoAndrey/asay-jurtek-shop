<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class OrderService
{
  public function store(User $user, $address, $city, $country, $items, $payment_method, $company, $cost_transfer, $cost, $phone)
  {

    return \DB::transaction(function () use ($user, $address, $city, $country, $items, $payment_method, $company, $cost_transfer, $cost, $phone) {

      $order   = new Order([
        'address'      => [
          'address'       => ''.Country::find($country)->name.','.City::find($city)->name.','. $address,
          'contact_name'  => $user->getIOName(),
          'contact_phone' => $phone,
        ],
        'total_amount' => $cost,
        'id_express_company' => $company,
        'payment_method' => $payment_method,
        'ship_price' => $cost_transfer
      ]);
      $order->user()->associate($user);
      $order->save();

      foreach ($items as $itemP) {
        $item = $order->items()->make([
          'price' => $itemP->on_sale ? $itemP->price_sale : $itemP->price,
        ]);
        $item->product()->associate($itemP);
        $item->save();
      }
      Product::destroy($order->items()->pluck('product_id'));

      return $order;
    });
  }

}
