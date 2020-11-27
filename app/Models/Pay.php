<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pay
 * Класс Модель для настроки оплаты
 * @package App\Models
 */
class Pay extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   * @var string[]
   */
  protected $fillable = [
    'pg_merchant_id',
    'pg_testing_mode',
    'pg_description',
    'url',
    'code',
    'name'
  ];

  /**
   * Тип полей
   * @var string[]
   */
  protected $casts = [
    'pg_testing_mode' => 'boolean',
  ];
}
