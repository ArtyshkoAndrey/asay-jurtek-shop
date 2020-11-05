<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ExpressCompany
 * Класс Модель для Компаний доставки
 *
 * @method static where(string $string, string $string1, string $string2)
 * @method static find($id)
 * @method create(array $all)
 */
class ExpressCompany extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'enabled',
    'cost_type',
    'track_code',
    'min_cost',
    'enabled_cash'
  ];

  /**
   * Типы данных
   *
   * @var string[]
   */
  protected $casts = [
    'enabled'      => 'boolean',
    'enabled_cash' => 'boolean'
  ];

  /**
   * Зоны компании
   *
   * @return HasMany
   */
  public function zones(): HasMany
  {
    return $this->hasMany(ExpressZone::class, 'company_id', 'id');
  }

  /**
   * Формат стоимости
   *
   * @param $num
   * @return string
   */
  public function cost ($num): string
  {
    return number_format($num, null, null, ' ');
  }

}
