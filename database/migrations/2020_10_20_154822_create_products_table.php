<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('sex')->default(\App\Models\Product::SEX_ATTR_MALE)->nullable();
      $table->text('description');
      $table->text('history')->nullable();
      $table->boolean('on_sale')->default(false);
      $table->boolean('on_new')->default(false);
      $table->decimal('price', 10, 0);
      $table->decimal('weight', 10, 2);
      $table->decimal('price_sale', 10, 0)->nullable();
      $table->unsignedBigInteger('skus_id');
      $table->foreign('skus_id')->references('id')->on('skuses')->onDelete('cascade');
      $table->json('meta')->nullable();
      $table->string('status')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('products');
    $table->dropSoftDeletes();
  }
}
