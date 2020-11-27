<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Currency
 * Класс Модель валюты
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property float $ratio
 * @property string $symbol
 * @property string $short_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 * @method static Builder|Currency whereCreatedAt($value)
 * @method static Builder|Currency whereId($value)
 * @method static Builder|Currency whereName($value)
 * @method static Builder|Currency whereRatio($value)
 * @method static Builder|Currency whereShortName($value)
 * @method static Builder|Currency whereSymbol($value)
 * @method static Builder|Currency whereUpdatedAt($value)
 * @mixin Eloquent
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
