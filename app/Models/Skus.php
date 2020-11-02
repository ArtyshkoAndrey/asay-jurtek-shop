<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skus extends Model
{
  use HasFactory;
  protected $fillable = ['title', 'weight'];

  public function skus_category () {
    return $this->belongsTo(SkusCategory::class, 'skus_category_id', 'id', 'skus_categories');
  }
}
