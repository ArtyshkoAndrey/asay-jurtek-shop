<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class PasswordReset
 * Уведомление при сбросе пароля
 * @package App\Notifications
 */
class PasswordReset extends Notification
{
  use Queueable;
  public $token;

  /**
   * Create a new notification instance.
   *
   * @param string $token
   */
  public function __construct(string $token)
  {
    $this->token = $token;
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
   * @return MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->subject('Востановление пароля')
      ->line('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.') // Here are the lines you can safely override
      ->action('Сброс пароля', url('password/reset', $this->token))
      ->line('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.');
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
