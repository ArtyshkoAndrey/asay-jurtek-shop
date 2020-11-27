<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Skus
 * Класс Модель для Размеров
 *
 * @package App\Models
 * @method static find($value)
 * @property int $id
 * @property string $title
 * @property int $weight
 * @property int $skus_category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read SkusCategory $skus_category
 * @method static Builder|Skus newModelQuery()
 * @method static Builder|Skus newQuery()
 * @method static Builder|Skus query()
 * @method static Builder|Skus whereCreatedAt($value)
 * @method static Builder|Skus whereId($value)
 * @method static Builder|Skus whereSkusCategoryId($value)
 * @method static Builder|Skus whereTitle($value)
 * @method static Builder|Skus whereUpdatedAt($value)
 * @method static Builder|Skus whereWeight($value)
 * @mixin Eloquent
 */
class Skus extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   * @var string[]
   */
  protected $fillable = ['title', 'weight'];

  /**
   * Категория размера
   * @return BelongsTo
   */
  public function skus_category (): BelongsTo
  {
    return $this->belongsTo(SkusCategory::class, 'skus_category_id', 'id', 'skus_categories');
  }
}
