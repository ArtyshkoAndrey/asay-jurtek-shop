<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Order
 * Класс Модель для Заказов
 *
 * @package App\Models
 * @method static find(int $id)
 */
class Order extends Model
{
  use HasFactory;

  /**
   * Статус заказа Обработка
   * @var string
   */
  const SHIP_STATUS_PENDING   = 'pending';

  /**
   * Статус заказа Не оплачен
   * @var string
   */
  const SHIP_STATUS_PAID      = 'paid';

  /**
   * Статус заказа Отправлен
   * @var string
   */
  const SHIP_STATUS_DELIVERED = 'delivered';

  /**
   * Статус заказа Получен
   * @var string
   */
  const SHIP_STATUS_RECEIVED  = 'received';

  /**
   * Статус заказа Отменён
   * @var string
   */
  const SHIP_STATUS_CANCEL    = 'cancel';

  /**
   * Вспомогательный масив статусов
   * @var string[]
   */
  const SHIP_STATUS_MAP = [
    self::SHIP_STATUS_PENDING,
    self::SHIP_STATUS_PAID,
    self::SHIP_STATUS_DELIVERED,
    self::SHIP_STATUS_RECEIVED,
    self::SHIP_STATUS_CANCEL
  ];

  /**
   * Метод оплаты Наличные
   * @var string
   */
  const PAYMENT_METHODS_CASH = 'cash';

  /**
   * Метод оплаты Картой
   * @var string
   */
  const PAYMENT_METHODS_CARD = 'card';

  /**
   * Массив методов оплаты на Русском
   * @var string[]
   */
  public static $paymentMethodsMap = [
    self::PAYMENT_METHODS_CASH  => 'Оплата в магазине',
    self::PAYMENT_METHODS_CARD  => 'Оплата картой',
  ];

  /**
   * Массив статуса заказов на Русском
   * @var string[]
   */
  public static $shipStatusMap = [
    self::SHIP_STATUS_PAID      => 'Не оплачен',
    self::SHIP_STATUS_PENDING   => 'В обработке',
    self::SHIP_STATUS_DELIVERED => 'Отправлен',
    self::SHIP_STATUS_RECEIVED  => 'Получен',
    self::SHIP_STATUS_CANCEL    => 'Отменён',
  ];

  /**
   * Поля в таблицы для работы
   * @var string[]
   */
  protected $fillable = [
    'no',
    'address',
    'total_amount',
    'paid_at',
    'payment_method',
    'id_express_company',
    'payment_no',
    'closed',
    'reviewed',
    'ship_status',
    'ship_data',
    'ship_price'
  ];

  /**
   * Массив типов данных
   * @var string[]
   */
  protected $casts = [
    'closed'    => 'boolean',
    'reviewed'  => 'boolean',
    'address'   => 'json',
    'ship_data' => 'json',
  ];

  /**
   * Тип дата для полей
   * @var string[]
   */
  protected $dates = [
    'paid_at',
  ];


  /**
   * Перегразка boot. Создание номера заказа
   */
  protected static function boot()
  {
    parent::boot();
    // Слушайте события создания модели и запускайте ее перед записью в базу данных.
    static::creating(function ($model) {
      // Если в модели нет поля пусто
      if (!$model->no) {
        // Вызовите findAvailableNo для создания серийного номера заказа
        $model->no = static::findAvailableNo();
        // Если генерация не удалась, завершите создание заказа
        if (!$model->no) {
          return false;
        }
      }
    });
  }

  /**
   * Пользовател заказа
   *
   * @return BelongsTo
   */
  public function user (): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Продукты в заказе
   *
   * @return HasMany
   */
  public function items ()
  {
    return $this->hasMany(OrderItem::class);
  }

  /**
   * Компания доставки заказа
   *
   * @return BelongsTo
   */
  public function expressCompany ()
  {
    return $this->belongsTo(ExpressCompany::class, 'id_express_company', 'id');
  }

  /**
   * Генерация номера заказа
   *
   * @return false|string
   * @throws Exception
   */
  public static function findAvailableNo ()
  {
    // Префикс серийного номера заказа
    $prefix = date('YmdHis');
    for ($i = 0; $i < 10; $i++) {
      // Случайно сгенерированный 6-значный номер
      $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
      // Определите, существует ли он уже
      if (!static::query()->where('no', $no)->exists()) {
        return $no;
      }
    }
    \Log::warning('find order no failed');

    return false;
  }

  /**
   * Форматирование стоимости
   *
   * @param $num
   * @return string
   */
  public function cost ($num) {
    return number_format($num, null, null, ' ');
  }
}
