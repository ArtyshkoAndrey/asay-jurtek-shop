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
 * Class ExpressCompany
 * Класс Модель для Компаний доставки
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $enabled
 * @property string $cost_type
 * @property string|null $track_code
 * @property int $min_cost
 * @property bool $enabled_cash
 * @property bool $enabled_card
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|ExpressZone[] $zones
 * @property-read int|null $zones_count
 * @method static Builder|ExpressCompany newModelQuery()
 * @method static Builder|ExpressCompany newQuery()
 * @method static Builder|ExpressCompany query()
 * @method static Builder|ExpressCompany whereCostType($value)
 * @method static Builder|ExpressCompany whereCreatedAt($value)
 * @method static Builder|ExpressCompany whereDescription($value)
 * @method static Builder|ExpressCompany whereEnabled($value)
 * @method static Builder|ExpressCompany whereEnabledCard($value)
 * @method static Builder|ExpressCompany whereEnabledCash($value)
 * @method static Builder|ExpressCompany whereId($value)
 * @method static Builder|ExpressCompany whereMinCost($value)
 * @method static Builder|ExpressCompany whereName($value)
 * @method static Builder|ExpressCompany whereTrackCode($value)
 * @method static Builder|ExpressCompany whereUpdatedAt($value)
 * @mixin Eloquent
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
