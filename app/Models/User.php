<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

  public function getFullAddress () {
    return "{$this->country->name}, {$this->city->name}, {$this->street}";
  }

  public function getIOName () {
    return "{$this->first_name} {$this->second_name}";
  }

  public function getPhoto () {
    return $this->avatar ? asset('public/avatar/avatar/thumbnail/' . $this->avatar) : asset('images/person.png');
  }


  public function currency () {
    return $this->belongsTo(Currency::class);
  }

  public function city () {
    return $this->belongsTo(City::class);
  }

  public function country () {
    return $this->balongsTo(Country::class);
  }

  public function favoriteProducts () {
    return $this->belongsToMany(Product::class, 'user_favorite_products')
      ->withTimestamps()
      ->orderBy('user_favorite_products.created_at', 'desc');
  }

  public function cartItems () {
    return $this->hasMany(CartItem::class);
  }

  public function sendPasswordResetNotification ($token) {
    $this->notify(new PasswordReset($token));
  }
}
