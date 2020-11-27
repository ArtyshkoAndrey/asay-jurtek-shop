<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Pay
 * Класс Модель для настроки оплаты
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property bool $pg_testing_mode
 * @property int $pg_merchant_id
 * @property string $pg_description
 * @property string $url
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Pay newModelQuery()
 * @method static Builder|Pay newQuery()
 * @method static Builder|Pay query()
 * @method static Builder|Pay whereCode($value)
 * @method static Builder|Pay whereCreatedAt($value)
 * @method static Builder|Pay whereId($value)
 * @method static Builder|Pay whereName($value)
 * @method static Builder|Pay wherePgDescription($value)
 * @method static Builder|Pay wherePgMerchantId($value)
 * @method static Builder|Pay wherePgTestingMode($value)
 * @method static Builder|Pay whereUpdatedAt($value)
 * @method static Builder|Pay whereUrl($value)
 * @mixin Eloquent
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
