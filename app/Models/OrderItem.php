<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OrderItem
 * Класс Модель для товаров в заказах
 *
 * @package App\Models
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
