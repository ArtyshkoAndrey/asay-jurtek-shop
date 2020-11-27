<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ExpressZone
 * Класс Модель Зон компаний
 */
class ExpressZone extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'cost',
    'cost_step',
    'step',
    'company_id'
  ];

  /**
   * Тип данных
   *
   * @var string[]
   */
  protected $casts = [
    'step_cost_array' => 'json'
  ];

  /**
   * Города зоны
   *
   * @return BelongsToMany
   */
  public function cities (): BelongsToMany
  {
    return $this->belongsToMany(City::class, 'city_expresses', 'express_zone_id', 'city_id')->withTimestamps()->orderBy('city_expresses.updated_at', 'DESC');
  }

  /**
   * Компания зоны
   *
   * @return BelongsTo
   */
  public function company (): BelongsTo
  {
    return $this->belongsTo(ExpressCompany::class, 'company_id', 'id');
  }

  /**
   * Вид стоимости
   *
   * @param $num
   * @return string
   */
  public function cost ($num): string
  {
    return number_format($num, null, null, ' ');
  }
}
