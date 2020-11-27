<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Product
 * Класс Модель для товаров
 *
 * @package App\Models
 * @property int $id
 * @property string $title
 * @property string|null $sex
 * @property string $description
 * @property string|null $history
 * @property bool $on_sale
 * @property bool $on_new
 * @property string $price
 * @property string $weight
 * @property string|null $price_sale
 * @property int $skus_id
 * @property object|null $meta
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|ProductsImage[] $photos
 * @property-read int|null $photos_count
 * @property-read Skus $skus
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereHistory($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereMeta($value)
 * @method static Builder|Product whereOnNew($value)
 * @method static Builder|Product whereOnSale($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product wherePriceSale($value)
 * @method static Builder|Product whereSex($value)
 * @method static Builder|Product whereSkusId($value)
 * @method static Builder|Product whereStatus($value)
 * @method static Builder|Product whereTitle($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Eloquent
 */
class Product extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * Поля для работы с таблицей
   * @var string[]
   */
  protected $fillable = [
    'title',
    'description',
    'on_sale',
    'price_sale',
    'price',
    'skus',
    'meta',
    'on_new',
    'sex',
    'history'
  ];

  /**
   * Тип полей
   * @var string[]
   */
  protected $casts = [
    'on_sale' => 'boolean', // Скидка
    'on_new'  => 'boolean', // Новая
    'meta'    => 'object'   // Данные ля СЕО
  ];

  /**
   * Отношения которые всегда подгружать
   * @var string[]
   */
  protected $with  = ['photos', 'skus'];

  /**
   * Поля с датой
   * @var string[]
   */
  protected $dates = ['deleted_at'];

  /**
   * Атрибут пол - мужчина
   * @var string
   */
  const SEX_ATTR_MALE = 'male';

  /**
   * Атрибут пол - женщина
   * @var string
   */
  const SEX_ATTR_FEMALE = 'female';

  /**
   * Атрибут пол - ребёнок
   * @var string
   */
  const SEX_ATTR_CHILDREN = 'children';

  /**
   * Массив всех атрибутов по полу
   * @var string[]
   */
  const SEX_ATTR_MAP = [
    self::SEX_ATTR_MALE,
    self::SEX_ATTR_FEMALE,
    self::SEX_ATTR_CHILDREN,
  ];

  /**
   * Массив перевода атрибутов пол
   * @var string[]
   */
  public static $sexAttrMap = [
    self::SEX_ATTR_MALE     => 'Мужской',
    self::SEX_ATTR_FEMALE   => 'Женский',
    self::SEX_ATTR_CHILDREN => 'Детский'
  ];

  /**
   * Категории товвара
   * @return BelongsToMany
   */
  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
  }

  /**
   * Фотографии товара
   * @return HasMany
   */
  public function photos(): HasMany
  {
    return $this->hasMany(ProductsImage::class, 'product_id', 'id');
  }

  /**
   * Размер товара
   * @return BelongsTo
   */
  public function skus(): BelongsTo
  {
    return $this->belongsTo(Skus::class);
  }

  /**
   * Форматирование стоимости товара
   * @param Currency|null $currency
   * @return string
   */
  public function cost (Currency $currency = null): string
  {
    return number_format(($this->on_sale? $this->price_sale : $this->price) * ($currency ? $currency->ratio : 1), null, null, ' ');
  }

  /**
   * Первая фотография товара
   * @return string
   */
  public function placeholder(): string
  {
    if (count($this->photos) > 0)
      return asset('storage/items/' . $this->photos[0]->name);
    else
      return asset('images/unnamed.png');
  }
}
