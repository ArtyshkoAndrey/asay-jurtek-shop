<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class SkusCategory
 * Класс Модель Категории размеров
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Skus[] $skuses
 * @property-read int|null $skuses_count
 * @method static Builder|SkusCategory newModelQuery()
 * @method static Builder|SkusCategory newQuery()
 * @method static Builder|SkusCategory query()
 * @method static Builder|SkusCategory whereCreatedAt($value)
 * @method static Builder|SkusCategory whereId($value)
 * @method static Builder|SkusCategory whereName($value)
 * @method static Builder|SkusCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SkusCategory extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   * @var string[]
   */
  protected $fillable = ['name'];

  /**
   * Размеры
   * @return HasMany
   */
  public function skuses (): HasMany
  {
    return $this->hasMany('App\Models\Skus');
  }
}
