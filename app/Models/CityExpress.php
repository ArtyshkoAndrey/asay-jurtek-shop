<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityExpress extends Model
{
  use HasFactory;

  public function cityOriginal() {
    return $this->hasOne(City::class, 'id', 'city_id');
  }
}
