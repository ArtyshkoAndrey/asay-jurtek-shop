<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * Класс модель для Настроек
 *
 * @method static where(string $string, string $string1)
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
  public function setStatusSite (bool $status): bool
  {
    try {
      $this->where('key', 'status')->first()->update(['meta' => $status]);
      return true;
    } catch (TypeError $e) {
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
      'text' => 'Asay Jurek',
      'description' => 'Селективный секонд хенд',
      'text_btn' => 'Перекти к покупкам',
      'link_btn' => '/product/all',
      'text_center' => false
    );
    $s->save();
  }
}
