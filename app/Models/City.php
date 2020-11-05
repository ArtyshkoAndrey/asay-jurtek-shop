<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class City
 * Класс Модель для городов
 *
 * @method static whereLike(string $string, string $city)
 * @method static whereHas(string $string, \Closure $param)
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
