<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Category Class
 * Класс Модель для Категорий
 *
 * @method static find($value)
 * @method static whereLike(string $string, string $category)
 */
class Category extends Model
{
  use HasFactory;

  /**
   * Поля для работы в таблице
   *
   * @var string[]
   */
  protected $fillable = [
    'name', 'id', 'to_index'
  ];

  /**
   * Указывает тип данных
   *
   * @var string[]
   */
  protected $casts = [
    'to_index' => 'boolean',
  ];

  /**
   * Поиск Like по нужным полям
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
   * Дочерние категории
   *
   * @return BelongsToMany
   */
  public function child(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'categories_categories', 'category_id', 'child_category_id');
  }

  /**
   * Родительская категория
   *
   * @return BelongsToMany
   */
  public function parents(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'categories_categories', 'child_category_id', 'category_id');
  }

  /**
   * Продукты в данной категории
   *
   * @return BelongsToMany
   */
  public function products(): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'products_categories', 'category_id', 'product_id');
  }
}
