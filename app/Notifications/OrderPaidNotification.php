<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderPaidNotification extends Notification implements ShouldQueue {
  use Queueable;

  protected $order;

  public function __construct(Order $order) {
    $this->order = $order;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable) {
    return (new MailMessage)
      ->subject('Ваш заказ успешно оплачен')
      ->greeting('Здраствуйте ' . $this->order->user->first_name)
      ->line($this->order->paid_at->format('d.m.Y H:i') . ' был оплачен ваш заказ по номеру ' . $this->order->no)
      ->action('Просмотреть статус заказа', route('orders.index'))
      ->success();
  }
}
