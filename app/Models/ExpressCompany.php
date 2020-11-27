<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ExpressCompany
 * Класс Модель для Компаний доставки
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
    'enabled_cash',
    'enabled_card',
    'description'
  ];

  /**
   * Типы данных
   *
   * @var string[]
   */
  protected $casts = [
    'enabled'      => 'boolean',
    'enabled_cash' => 'boolean',
    'enabled_card' => 'boolean'
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
