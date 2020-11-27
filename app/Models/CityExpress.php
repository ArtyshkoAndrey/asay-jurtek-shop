<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class CityExpress
 * Класс Модель для Города в доставке
 *
 * @package App\Models
 * @property int $id
 * @property int $city_id
 * @property int $express_zone_id
 * @property int $express_company_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read City|null $cityOriginal
 * @method static Builder|CityExpress newModelQuery()
 * @method static Builder|CityExpress newQuery()
 * @method static Builder|CityExpress query()
 * @method static Builder|CityExpress whereCityId($value)
 * @method static Builder|CityExpress whereCreatedAt($value)
 * @method static Builder|CityExpress whereExpressCompanyId($value)
 * @method static Builder|CityExpress whereExpressZoneId($value)
 * @method static Builder|CityExpress whereId($value)
 * @method static Builder|CityExpress whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CityExpress extends Model
{
  use HasFactory;

  // TODO: Понять, что вообще за модель и нужна ли она

  /**
   * Я пока хз что это
   *
   * @return HasOne
   */
  public function cityOriginal() {
    return $this->hasOne(City::class, 'id', 'city_id');
  }
}
