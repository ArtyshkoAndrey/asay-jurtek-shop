<?php

namespace App\Services;

use App\Models\CartItem;
use App\Exceptions\InvalidRequestException;
use Illuminate\Support\Facades\Auth;

/**
 * Class CartService
 * Сервис для работы с корзиной у пользователя
 * @package App\Services
 */
class CartService {

  /**
   * Взять все товары у пользователя
   * @return array
   */
  public function get(): array
  {
    $cartItems = Auth::user()->cartItems()->with(['product'])->get();
    $priceAmount = 0;
    $items = [];
    foreach ($cartItems as $cartItem) {
      if ($cartItem->product) {
        $product = $cartItem->product;
        array_push($items, $product);
        $priceAmount += $product->on_sale ? $product->price_sale : $product->price;
      } else {
        $cartItem->delete();
      }
    }
    $amount = count($cartItems);
    return ['amount'=> $amount, 'priceAmount' => $priceAmount, 'cartItems' => $items];
  }

  /**
   * Добавить товар в корзине
   * @param int $id
   * @return CartItem
   * @throws InvalidRequestException
   */
  public function add(int $id): CartItem
  {
    $user = Auth::user();
    if ($item = $user->cartItems()->where('product_id', $id)->first()) {
//      Если таков товар есть в корзине
      throw new InvalidRequestException('Товар уже в корзине');
    } else {
      $item = new CartItem();
      $item->product()->associate($id);
      $item->user()->associate($user);
      $item->save();
    }
    return $item;
  }


  /**
   * Удалить 1 и более товара
   * @param $ids
   */
  public function remove($ids)
  {
    if (!is_array($ids)) {
//      Если пришёл не массив
      $ids = [$ids];
    }
    Auth::user()->cartItems()->whereIn('product_id', $ids)->delete();
  }

  /**
   * Удалить все товары
   */
  public function deleteAll()
  {
    Auth::user()->cartItems()->delete();
  }

  /**
   * Получить вол-во товаров
   * @return int
   */
  public function amount (): int
  {
    $user = Auth::user();
    return count($user->cartItems()->get());
  }

  /**
   * Получить стоимость всех товаров в корзине
   * @return int
   */
  public function priceAmount (): int
  {
    $user = Auth::user();
    return $user->cartItems()
      ->get()
      ->map(function ($item) {
        return $item->product->on_sale ? $item->product->price_sale : $item->product->price;
      })
      ->sum();
  }
}
