<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  use HasFactory;

  protected $fillable = [
    'name', 'id'
  ];

  public function scopeWhereLike($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  public function categories() {
    return $this->belongsToMany(Category::class, 'brands_categories', 'brand_id', 'category_id');
  }

  public function products() {
    return $this->belongsToMany(Product::class, 'products_brands', 'brand_id', 'product_id');
  }
}
