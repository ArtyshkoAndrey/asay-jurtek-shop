<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class User
 * Класс Модель для Пользователя
 *
 * @package App\Models
 * @property int $id
 * @property string $first_name
 * @property string $second_name
 * @property string|null $patronymic
 * @property string|null $street
 * @property string|null $avatar
 * @property string|null $contact_phone
 * @property int|null $city_id
 * @property int|null $country_id
 * @property int|null $currency_id
 * @property bool $is_admin
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|CartItem[] $cartItems
 * @property-read int|null $cart_items_count
 * @property-read City|null $city
 * @property-read Country|null $country
 * @property-read Currency|null $currency
 * @property-read Collection|Product[] $favoriteProducts
 * @property-read int|null $favorite_products_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCityId($value)
 * @method static Builder|User whereContactPhone($value)
 * @method static Builder|User whereCountryId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrencyId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePatronymic($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSecondName($value)
 * @method static Builder|User whereStreet($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
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
      ->withDefault();
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
