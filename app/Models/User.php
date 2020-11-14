<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * Класс Модель для Пользователя
 *
 * @package App\Models
 * @method static find()
 * @method static where(string $string, $email)
 */
class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'first_name',
    'second_name',
    'patronymic',
    'street',
    'avatar',
    'contact_phone',
    'email',
    'password',
    'is_admin'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'is_admin' => 'boolean'
  ];

  /**
   * Получить полный адресс в виде строки
   * @return string
   */
  public function getFullAddress (): string
  {
    if ($this->country && $this->city && $this->street)
      return "{$this->country->name}, {$this->city->name}, {$this->street}";

    return 'Нет данных';
  }

  /**
   * Получить Имя Фамилию пользователя
   * @return string
   */
  public function getFSName (): string
  {
    return "{$this->first_name} {$this->second_name}";
  }

  /**
   * Получить фотографи
   * @return string
   */
  public function getPhoto (): string
  {
    return $this->avatar ? asset('storage/avatar/' . $this->avatar) : asset('images/person.png');
  }


  /**
   * Валюта пользователя
   * @return BelongsTo
   */
  public function currency (): BelongsTo
  {
    return $this->belongsTo(Currency::class);
  }

  /**
   * Город пользователя
   * @return BelongsTo
   */
  public function city (): BelongsTo
  {
    return $this
      ->belongsTo(City::class)
      ->withDefault();;
  }

  /**
   * Страна пользователя
   * @return BelongsTo
   */
  public function country (): BelongsTo
  {
    return $this
      ->belongsTo(Country::class)
      ->withDefault();
  }

  /**
   * Товары в избраных
   * @return BelongsToMany
   */
  public function favoriteProducts (): BelongsToMany
  {
    return $this
      ->belongsToMany(Product::class, 'user_favorite_products')
      ->withTimestamps()
      ->orderBy('user_favorite_products.created_at', 'desc');
  }

  /**
   * Товары в корзине
   * @return HasMany
   */
  public function cartItems (): HasMany
  {
    return $this->hasMany(CartItem::class);
  }

  /**
   * Уведомления о сбросе пароля
   * @param string $token
   */
  public function sendPasswordResetNotification ($token)
  {
    $this->notify(new PasswordReset($token));
  }

  /**
   * Заказы пользователя
   * @return HasMany
   */
  public function orders () {
    return $this->hasMany(Order::class);
  }
}
