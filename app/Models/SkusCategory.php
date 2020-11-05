<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SkusCategory
 * Класс Модель Категории размеров
 * @package App\Models
 */
class SkusCategory extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   * @var string[]
   */
  protected $fillable = ['name'];

  /**
   * Размеры
   * @return HasMany
   */
  public function skuses (): HasMany
  {
    return $this->hasMany('App\Models\Skus');
  }
}
