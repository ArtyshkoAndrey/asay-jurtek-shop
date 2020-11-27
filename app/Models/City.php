<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class City
 * Класс Модель для городов
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Country|null $country
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCountryId($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereLike($column, $value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @mixin Eloquent
 */
class City extends Model
{
  use HasFactory;

  /**
   * Поля для работы в таблицей
   *
   * @var string[]
   */
  protected $fillable = [
    'name'
  ];

  /**
   * Страна данного города
   *
   * @return HasOne
   */
  public function country () {
    return $this->hasOne(Country::class, 'id', 'country_id');
  }

  /**
   * Поиск в таблице
   *
   * @param $query
   * @param $column
   * @param $value
   * @return mixed
   */
  public function scopeWhereLike($query, $column, $value) {
    return $query->where($column, 'like', '%'.$value.'%');
  }
}
