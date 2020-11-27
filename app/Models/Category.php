<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Category Class
 * Класс Модель для Категорий
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $to_menu
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $child
 * @property-read int|null $child_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LinkMenu[] $linksFilter
 * @property-read int|null $links_filter_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $parents
 * @property-read int|null $parents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereLike($column, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereToMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
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

  public function linksFilter ()
  {
    return $this->hasMany(LinkMenu::class);
  }
}
