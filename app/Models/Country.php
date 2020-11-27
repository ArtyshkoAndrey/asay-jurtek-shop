<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Country
 * Класс Модель для стран
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
