<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterPassword extends Notification
{
  use Queueable;
  protected $email;
  protected $password;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($email, $password)
  {
    $this->email = $email;
    $this->password = $password;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
      return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->subject('Новый аккаунт')
      ->greeting('Здраствуйте')
      ->line('Вы успешно зарегестрировались')
      ->line('Ваш логин: ' . $this->email)
      ->line('Ваш пароль: ' . $this->password)
      ->action('Просмотреть новые товары', route('products.all', ['order' => 'new_desc']))
      ->success();
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}
