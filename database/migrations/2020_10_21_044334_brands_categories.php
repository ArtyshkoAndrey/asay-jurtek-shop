<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BrandsCategories extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('brands_categories', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('brand_id');
      $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
      $table->unsignedBigInteger('category_id');
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('  cascade');
      $table->timestamps();
    });  
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('brands_categories');
  }
}
