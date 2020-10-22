<?php

namespace App\Services;

use App\Models\Product;
use Auth;
use App\Models\CartItem;

class CartService
{
  public function get()
  {
    $cartItems = Auth::user()->cartItems()->with(['productSku.product'])->get();
    $ids = [];
    foreach ($cartItems as $item) {
      $ids += array_fill(count($ids), $item->amount, $item->product_sku_id);
    }
    $productsSku = Product::getProducts($ids);
    $priceAmount = 0;
    $cartItems = [];
    $amount = 0;
    foreach ($productsSku as $k => $productSku) {
      $id = (int)$productSku->id;
      $amount++;
      $ch = false;
      $item = [];

      foreach ($cartItems as $key => $item) {
        if (($item['id'] === $productSku->id) && ($item['product_sku']->product->price === $productSku->product->price)) {
          $ch = true;
          $cartItems[$key]['amount'] = $item['amount'] + 1;
          $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
          break;
        }
      }
      if (!$ch) {
        $item['amount'] = 1;
        $item['id'] = $id;
        $item['product_sku'] = $productSku;
        $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
        array_push($cartItems, $item);
      }
    }
    return ['amount'=> $amount, 'priceAmount' => $priceAmount, 'cartItems' => $cartItems];
  }

  public function add($skuId, $amount)
  {
    $user = Auth::user();
    // 从数据库中查询该商品是否已经在购物车中
    if ($item = $user->cartItems()->where('product_sku_id', $skuId)->first()) {
      // 如果存在则直接叠加商品数量
      $item->update([
        'amount' => $item->amount + $amount,
      ]);
    } else {
      // 否则创建一个新的购物车记录
      $item = new CartItem(['amount' => $amount]);
      $item->user()->associate($user);
      $item->productSku()->associate($skuId);
      $item->save();
    }

    return $item;
  }

  public function minusAmount($skuId, $amount)
  {
    $user = Auth::user();
    if ($item = $user->cartItems()->where('product_sku_id', $skuId)->first()) {
      if ($amount <= 0) {
        $item->update([
          'amount' => $item->amount - 1
        ]);
      } else {
        $item->update([
          'amount' => $amount,
        ]);
      }
    } else {
      // 否则创建一个新的购物车记录
      $item = new CartItem(['amount' => $amount]);
      $item->user()->associate($user);
      $item->productSku()->associate($skuId);
      $item->save();
    }

    return $item;
  }

  public function remove($skuIds)
  {
      // 可以传单个 ID，也可以传 ID 数组
      if (!is_array($skuIds)) {
          $skuIds = [$skuIds];
      }
      Auth::user()->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
  }

  public function amount ()
  {
    $user = Auth::user();
    return $user->cartItems()->get()->map(function ($item) {
      return $item->amount;
    })->sum();
  }

  public function priceAmount ()
  {
    $user = Auth::user();
    $user->cartItems()->get()->map(function ($item) {
      if($item->productSku->product === null) {
        $item->delete();
      }
    });
    return $user->cartItems()->get()->map(function ($item) {
      return ($item->productSku->product->on_sale ? $item->productSku->product->price_sale : $item->productSku->product->price) * $item->amount;
    })->sum();
  }
}
