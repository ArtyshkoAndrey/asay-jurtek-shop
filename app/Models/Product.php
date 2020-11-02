<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = [
    'title', 'description', 'on_sale',
    'price_sale', 'price', 'skus',
    'meta', 'on_new'
  ];
  protected $casts = [
    'on_sale' => 'boolean', // Скидка
    'on_new'  => 'boolean', // Новая
    'meta'    => 'object'   // Данные ля СЕО
  ];

  protected $with  = ['photos'];
  protected $dates = ['deleted_at'];

  const SEX_ATTR_MALE = 'male';
  const SEX_ATTR_FEMALE = 'female';
  const SEX_ATTR_CHILDREN = 'children';

  const SEX_ATTR_MAP = [
    self::SEX_ATTR_MALE,
    self::SEX_ATTR_FEMALE,
    self::SEX_ATTR_CHILDREN,
  ];

  public static $sexAttrMap = [
    self::SEX_ATTR_MALE      => 'Мужской',
    self::SEX_ATTR_FEMALE   => 'Женский',
    self::SEX_ATTR_CHILDREN => 'Детский'
  ];

  public function categories() {
    return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
  }

  public function brands() {
    return $this->belongsToMany(Brand::class, 'products_brands', 'product_id', 'brand_id');
  }

  public function photos() {
    return $this->hasMany(ProductsImage::class, 'product_id', 'id');
  }

  public function skus() {
    return $this->belongsTo(Skus::class);
  }


  public function cost (Currency $currency = null) {
    return number_format($this->price * ($currency ? $currency->ratio : 1), null, null, ' ');
  }

  public function placeholder() {
    if (count($this->photos) > 0)
      return asset('storage/items/' . $this->photos[0]->name);
    else
      return asset('images/unnamed.png');
  }
}
