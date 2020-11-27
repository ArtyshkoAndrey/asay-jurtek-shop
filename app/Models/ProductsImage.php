<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class ProductsImage
 * Класс Модель для Фотограйии товара
 *
 * @package App\Models
 * @property int $id
 * @property int|null $product_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product|null $product
 * @method static Builder|ProductsImage newModelQuery()
 * @method static Builder|ProductsImage newQuery()
 * @method static Builder|ProductsImage query()
 * @method static Builder|ProductsImage whereCreatedAt($value)
 * @method static Builder|ProductsImage whereId($value)
 * @method static Builder|ProductsImage whereName($value)
 * @method static Builder|ProductsImage whereProductId($value)
 * @method static Builder|ProductsImage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductsImage extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   * @var string[]
   */
  protected $fillable = [
    'name'
  ];

  /**
   * Товар фотографии
   * @return BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
  }
}
