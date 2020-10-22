<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  const SHIP_STATUS_PENDING   = 'pending';
  const SHIP_STATUS_PAID      = 'paid';
  const SHIP_STATUS_DELIVERED = 'delivered';
  const SHIP_STATUS_RECEIVED  = 'received';
  const SHIP_STATUS_CANCEL    = 'cancel';

  const SHIP_STATUS_MAP = [
    self::SHIP_STATUS_PENDING,
    self::SHIP_STATUS_PAID,
    self::SHIP_STATUS_DELIVERED,
    self::SHIP_STATUS_RECEIVED,
    self::SHIP_STATUS_CANCEL
  ];

  const PAYMENT_METHODS_CASH = 'cash';
  const PAYMENT_METHODS_CARD = 'card';

  public static $paymentMethodsMap = [
    self::PAYMENT_METHODS_CASH  => 'Оплата в магазине',
    self::PAYMENT_METHODS_CARD  => 'Оплата картой',
  ];

  public static $shipStatusMap = [
    self::SHIP_STATUS_PAID      => 'Не оплачен',
    self::SHIP_STATUS_PENDING   => 'В обработке',
    self::SHIP_STATUS_DELIVERED => 'Отправлен',
    self::SHIP_STATUS_RECEIVED  => 'Получен',
    self::SHIP_STATUS_CANCEL    => 'Отменён',
  ];

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

  protected $casts = [
    'closed'    => 'boolean',
    'reviewed'  => 'boolean',
    'address'   => 'json',
    'ship_data' => 'json',
  ];

  protected $dates = [
    'paid_at',
  ];

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

  public function user ()
  {
    return $this->belongsTo(User::class);
  }

  public function items ()
  {
    return $this->hasMany(OrderItem::class);
  }
  public function expressCompany ()
  {
    return $this->belongsTo(ExpressCompany::class, 'id_express_company', 'id');
  }

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
  public static function getAvailableRefundNo ()
  {
    do {
      // Класс Uuid может быть использован для генерации уникальных строк с высокой вероятностью
      $no = Uuid::uuid4()->getHex();
      // Чтобы избежать повторения, мы запрашиваем базу данных после генерации, чтобы узнать, существует ли такой же номер заказа на возврат.
    } while (self::query()->where('refund_no', $no)->exists());
    return $no;
  }
}
