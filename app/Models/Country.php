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
 * Class Country
 * Класс Модель для стран
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|City[] $cities
 * @property-read int|null $cities_count
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereLike($column, $value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Country extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   *
   * @var string[]
   */
  protected $fillable = [
    'name'
  ];

  /**
   * Поиск по колонкам
   *
   * @param $query
   * @param $column
   * @param $value
   * @return mixed
   */
  public function scopeWhereLike ($query, $column, $value) {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  /**
   * Города данной страны
   *
   * @return HasMany
   */
  public function cities (): HasMany
  {
    return $this->hasMany(City::class, 'country_id', 'id');
  }
}
