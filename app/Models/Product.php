<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    'on_sale' => 'boolean',
    'on_new'  => 'boolean',
    'meta'    => 'object'
  ];

  protected $with  = ['photos'];
  protected $dates = ['deleted_at'];

  public function categories() {
    return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
  }

  public function brands() {
    return $this->belongsToMany(Brand::class, 'products_brands', 'product_id', 'brand_id');
  }

  public function photos() {
    return $this->hasMany(Photo::class, 'product_id', 'id');
  }
}
