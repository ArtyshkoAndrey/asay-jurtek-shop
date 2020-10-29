<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpressCompany extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'enabled',
    'cost_type',
    'track_code',
    'min_cost',
    'enabled_cash'
  ];

  protected $casts = [
    'enabled'      => 'boolean',
    'enabled_cash' => 'boolean'
  ];

  public function zones() {
    return $this->hasMany(ExpressZone::class, 'company_id', 'id');
  }
  public function cost ($num) {
    return number_format($num, null, null, ' ');
  }

}
