<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * Класс Модель для товаров
 *
 * @method static take(int $int)
 * @method static findMany($ids)
 * @method static where(string $string, bool $true)
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
