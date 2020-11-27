<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OrderItem
 * Класс Модель для товаров в заказах
 *
 * @package App\Models
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $price
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read Order $order
 * @property-read Product $product
 * @method static Builder|OrderItem newModelQuery()
 * @method static Builder|OrderItem newQuery()
 * @method static Builder|OrderItem query()
 * @method static Builder|OrderItem whereCreatedAt($value)
 * @method static Builder|OrderItem whereId($value)
 * @method static Builder|OrderItem whereOrderId($value)
 * @method static Builder|OrderItem wherePrice($value)
 * @method static Builder|OrderItem whereProductId($value)
 * @method static Builder|OrderItem whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderItem extends Model
{
  use HasFactory;

  /**
   * Поля для работы с товарами
   * @var string[]
   */
  protected $fillable = ['price'];

  /**
   * Без записи даты
   * @var bool
   */
  public $timestamps = false;

  /**
   * Товар
   * @return BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class)->withTrashed();
  }

  /**
   * Сам заказ
   * @return BelongsTo
   */
  public function order(): BelongsTo
  {
    return $this->belongsTo(Order::class);
  }
}
