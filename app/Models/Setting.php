<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Setting
 * Класс модель для Настроек
 *
 * @package App\Models
 * @property int $id
 * @property string $key
 * @property object $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereKey($value)
 * @method static Builder|Setting whereMeta($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Setting extends Model
{
  use HasFactory;

  /**
   * Поля для работы
   * @var string[]
   */
  protected $fillable = ['key', 'meta'];

  /**
   * Тип полей
   * @var string[]
   */
  protected $casts = [
    'meta' => "object",
    'key' => 'string'
  ];

  /**
   * Функция для получения статуса сайта
   *
   * @return bool
   */
  public static function getStatusSite (): bool
  {
    return boolval(self::where('key', 'status')->first()->meta);
  }


  /**
   * Функция для изменения статуса сайта
   *
   * @param bool $status
   * @return bool
   */
  public static function setStatusSite (bool $status): bool
  {
    try {
      self::where('key', 'status')->first()->update(['meta' => $status]);
      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * Функция для создание настройки шапки
   */
  public function setHeader ()
  {
    $s = new Setting();
    $s->key = 'header';
    $s->meta = array(
      'image' => 'http://zakaz/images/586e6940ea673b0ebbdc6668f59ca32a.jpg',
      'position' => 'right', //left
      'width' => '50',
      'color_gradient' => '#D1BC8A',
      'gradient_position' => 'left-to-right', //right-to-left
      'gradient' => true,
      'text' => 'Asaý Júrek',
      'description' => 'Селективный секонд хенд',
      'text_btn' => 'Перекти к покупкам',
      'link_btn' => '/product/all',
      'text_center' => false
    );
    $s->save();
  }
}
