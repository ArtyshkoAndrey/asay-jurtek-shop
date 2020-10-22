<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressZonesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('express_zones', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('express_companies')->onDelete('cascade');
      $table->decimal('cost', 10, 0)->nullable();
      $table->double('step', 10, 2)->nullable();
      $table->decimal('cost_step', 10, 0)->nullable();
      $table->text('step_cost_array')->nullable();
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
    Schema::dropIfExists('express_zones');
  }
}
