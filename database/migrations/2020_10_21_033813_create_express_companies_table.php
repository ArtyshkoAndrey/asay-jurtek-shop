<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressCompaniesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('express_companies', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->boolean('enabled')->default(true);
      $table->string('cost_type')->default('Настраиваемая');
      $table->text('track_code')->nullable();
      $table->integer('min_cost')->default(0);
      $table->boolean('enabled_cash')->default(false);
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
    Schema::dropIfExists('express_companies');
  }
}
