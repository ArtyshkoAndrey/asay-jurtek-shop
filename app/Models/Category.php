<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;
  protected $fillable = [
    'name', 'id', 'to_index'
  ];

  protected $casts = [
    'to_index' => 'boolean',
  ];
  public function scopeWhereLike($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  public function child() {
    return $this->belongsToMany(Category::class, 'categories_categories', 'category_id', 'child_category_id');
  }

  public function parents() {
    return $this->belongsToMany(Category::class, 'categories_categories', 'child_category_id', 'category_id');
  }

  public function products() {
    return $this->belongsToMany(Product::class, 'products_categories', 'category_id', 'product_id');
  }
}
