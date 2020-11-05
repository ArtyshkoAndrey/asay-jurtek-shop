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
    'meta' => 'string',
    'key' => 'string'
  ];

  /**
   * Функция для смены статуса сайта
   *
   * @param null $status
   * @return bool
   */
  public function statusSite ($status = null): bool
  {
    if ($status === null)
      return boolval($this->where('key', 'status')->first()->meta);
    else
      $this->where('key', 'status')->first()->update(['meta' => $status]);
  }

  /**
   * Функция для создание настройки шапки
   */
  public function setHeader ()
  {
    $s = new Setting();
    $s->key = 'header';
    $s->meta = json_encode(array(
      'image' => 'http://zakaz/images/586e6940ea673b0ebbdc6668f59ca32a.jpg',
      'position' => 'right', //left
      'width' => '50',
      'color_gradient' => '#D1BC8A',
      'gradient_position' => 'left-to-right', //right-to-left
      'gradient' => true
    ));
    $s->save();
  }
}
