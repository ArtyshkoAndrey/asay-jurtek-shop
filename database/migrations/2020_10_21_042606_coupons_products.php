<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CouponsProducts extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupons_products', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('coupon_id');
      $table->unsignedBigInteger('product_id');
      $table->foreign('coupon_id')->references('id')->on('coupon_codes')->onDelete('  cascade');
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('coupons_products');
  }
}
