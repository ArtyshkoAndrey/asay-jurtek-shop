<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCodesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupon_codes', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('code')->unique();
      $table->string('type');
      $table->decimal('value');
      $table->unsignedInteger('total');
      $table->unsignedInteger('used')->default(0);
      $table->decimal('min_amount', 10, 0);
      $table->decimal('max_amount', 10, 0);
      $table->boolean('disabled_other_coupons')->default(false);
      $table->boolean('disabled_other_sales')->default(false);
      $table->datetime('not_before')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->datetime('not_after');
      $table->boolean('enabled')->default(true);
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
    Schema::dropIfExists('coupon_codes');
  }
}
