<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  use HasFactory;
  protected $fillable   = ['amount', 'price', 'rating', 'review', 'reviewed_at', 'product_sku'];
  protected $dates      = ['reviewed_at'];
  public    $timestamps = false;

  public function product() {
    return $this->belongsTo(Product::class)->withTrashed();
  }

  public function order() {
    return $this->belongsTo(Order::class);
  }
}
