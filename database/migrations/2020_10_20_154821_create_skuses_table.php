<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkusesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('skuses', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->integer('weight');
      $table->unsignedBigInteger('skus_category_id');
      $table->foreign('skus_category_id')->references('id')->on('skus_categories')->onDelete('cascade');
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
    Schema::dropIfExists('skuses');
  }
}
