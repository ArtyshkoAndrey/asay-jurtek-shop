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
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUserId($value)
 * @mixin \Eloquent
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
