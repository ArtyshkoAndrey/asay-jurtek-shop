<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class CityExpress
 * Класс Модель для Города в доставке
 *
 * @package App\Models
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
