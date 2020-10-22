<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->string('no')->unique();
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->text('address');
      $table->decimal('total_amount', 10, 0);
      $table->decimal('ship_price', 10, 0);
      $table->dateTime('paid_at')->nullable();
      $table->string('payment_method')->nullable();
      $table->string('payment_no')->nullable();
      $table->boolean('closed')->default(false);
      $table->boolean('reviewed')->default(false);
      $table->string('ship_status')->default(\App\Models\Order::SHIP_STATUS_PAID);
      $table->text('ship_data')->nullable();
      $table->unsignedBigInteger('id_express_company')->nullable();
      $table->foreign('id_express_company')->references('id')->on('express_companies')->onDelete('set null');
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
    Schema::dropIfExists('orders');
  }
}
