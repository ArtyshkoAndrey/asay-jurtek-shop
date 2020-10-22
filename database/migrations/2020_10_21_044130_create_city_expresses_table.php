<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityExpressesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('city_expresses', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('city_id');
      $table->unsignedBigInteger('express_zone_id');
      $table->unsignedBigInteger('express_company_id');
      $table->foreign('express_zone_id')->references('id')->on('express_zones')->onDelete('cascade');
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
      $table->foreign('express_company_id')->references('id')->on('express_companies')->onDelete('cascade');
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
    Schema::dropIfExists('city_expresses');
  }
}
