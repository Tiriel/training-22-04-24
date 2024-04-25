<?php

namespace App\Movie\Factory;

use App\Movie\Notifications\SlackNotification;
use Symfony\Component\Notifier\Notification\Notification;

class SlackNotificationFactory implements NotificationFactoryInterface
{

    public function createNotification(string $subject): Notification
    {
        return new SlackNotification($subject);
    }

    public static function getIndex(): string
    {
        return 'slack';
    }
}
