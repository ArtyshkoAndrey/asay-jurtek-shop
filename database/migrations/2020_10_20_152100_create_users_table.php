<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('first_name');
      $table->string('second_name');
      $table->string('patronymic')->nullable();
      $table->string('street');
      $table->text('avatar')->nullable();
      $table->string('contact_phone');
      $table->unsignedBigInteger('city_id')->nullable();
      $table->unsignedBigInteger('country_id')->nullable();
      $table->unsignedBigInteger('currency_id')->nullable();
      $table->boolean('is_admin')->default(false);
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('set NULL');
      $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
      $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
}
