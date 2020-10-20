<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  use HasFactory;

  protected $fillable = [
    'name'
  ];

  public function scopeWhereLike ($query, $column, $value) {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  public function cities () {
    return $this->hasMany(City::class, 'country_id', 'id');
  }
}
