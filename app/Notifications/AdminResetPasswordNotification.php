<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
  use Queueable;
  public $token;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($token)
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
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->line('Вы получаете это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.')
      ->action('Сбросить пароль', route('admin.auth.password.reset', $this->token))
      ->line('Если вы не запросили сброс пароля, никаких дальнейших действий не требуется.');
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
