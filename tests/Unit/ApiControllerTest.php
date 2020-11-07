<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiControllerTest extends TestCase
{

//  TODO: После выполнения проекта написать тесты.
  public function testGetCurrency()
  {

    $response = $this->json('POST', 'api/currency/get/1');

    $response
      ->assertStatus(200)
      ->assertJson([
        'created_at' => true,
      ]);
  }

  public function testProductsCheck()
  {

  }

  public function testCountry()
  {

  }

  public function testCategory()
  {

  }

  public function testCity()
  {

  }
}
