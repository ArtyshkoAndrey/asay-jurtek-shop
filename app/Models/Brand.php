<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Brand.
 * Класс Модель брендов у товаров
 *
 * @method static whereLike(string $string, string $brand)
 */
class Brand extends Model
{
  use HasFactory;

  /**
   * Доступные колокни для работы
   *
   * @var string[]
   */
  protected $fillable = [
    'name', 'id'
  ];

  /**
   * Скоп для фильтрации Like в колонках
   *
   * @param $query
   * @param $column
   * @param $value
   * @return mixed
   */
  public function scopeWhereLike($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  /**
   * Отношение бренда с категориями
   *
   * @return BelongsToMany
   */
  public function categories() {
    return $this->belongsToMany(Category::class, 'brands_categories', 'brand_id', 'category_id');
  }

  /**
   * Отношения бренда с продуктами
   *
   * @return BelongsToMany
   */
  public function products() {
    return $this->belongsToMany(Product::class, 'products_brands', 'brand_id', 'product_id');
  }
}
