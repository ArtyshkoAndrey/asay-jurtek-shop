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
}
