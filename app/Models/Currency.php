<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * Класс Модель валюты
 *
 * @method static find(int $id)
 */
class Currency extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'ratio',
    'symbol',
    'short_name'
  ];
}
