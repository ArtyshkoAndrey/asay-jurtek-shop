<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = User::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'first_name' => $this->faker->name,
      'second_name' => $this->faker->name,
      'patronymic' => $this->faker->name,
      'street' => $this->faker->address,
      'avatar' => 'null',
      'contact_phone' => $this->faker->e164PhoneNumber,
      'city_id' => 1,
      'country_id' => 1,
      'currency_id' => 1,
      'email' => $this->faker->unique()->safeEmail,
      'email_verified_at' => now(),
      'password' => Hash::make('123123'), // password
      'remember_token' => Str::random(10),
    ];
  }
}
