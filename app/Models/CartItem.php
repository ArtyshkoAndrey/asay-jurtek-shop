<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CartItem
 * Класс Модель товаров в корзине
 *
 * @package App\Models
 */
class CartItem extends Model
{
  use HasFactory;

  /**
   * Поля доступные для работы в таблице
   *
   * @var string[]
   */
  protected $fillable = ['product_id'];

  /**
   * Не вносить дату в таблицу
   *
   * @var bool
   */
  public $timestamps  = false;

  /**
   * Отношения пользователя к данному товару в корзине
   *
   * @return BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Отношения Продукта к данному товару в корзине
   *
   * @return BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }

}
