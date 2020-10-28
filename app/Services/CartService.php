<?php

namespace App\Services;

use App\Models\CartItem;
use App\Exceptions\InvalidRequestException;
use Illuminate\Support\Facades\Auth;

class CartService {
  public function get()
  {
    $cartItems = Auth::user()->cartItems()->with(['product'])->get();
    $priceAmount = 0;
    $items = [];
    foreach ($cartItems as $cartItem) {
      $product = $cartItem->product;
      array_push($items, $product);
      $priceAmount += $product->on_sale ? $product->price_sale : $product->price;
    }
    $amount = count($cartItems);
    return ['amount'=> $amount, 'priceAmount' => $priceAmount, 'cartItems' => $items];
  }

  public function add($id)
  {
    $user = Auth::user();
    if ($item = $user->cartItems()->where('product_id', $id)->first()) {
      throw new InvalidRequestException('Товар уже в корзине');
    } else {
      $item = new CartItem();
      $item->product()->associate($id);
      $item->user()->associate($user);
      $item->save();
    }
    return $item;
  }


  public function remove($ids)
  {
    if (!is_array($ids)) {
        $ids = [$ids];
    }
    Auth::user()->cartItems()->whereIn('product_id', $ids)->delete();
  }

  public function deleteAll()
  {
    dd(Auth::user()->cartItems()->get());
    Auth::user()->cartItems()->all()->delete();
  }

  public function amount ()
  {
    $user = Auth::user();
    return count($user->cartItems()->get());
  }

  public function priceAmount ()
  {
    $user = Auth::user();
    return $user->cartItems()->get()->map(function ($item) {
      return $item->product->on_sale ? $item->product->price_sale : $item->product->price;
    })->sum();
  }
}
