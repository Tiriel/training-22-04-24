<?php

namespace App\Movie\Notifier\Factory;

use App\Movie\Notifier\Factory\NotificationFactoryInterface;
use App\Movie\Notifier\Notifications\SlackNotification;
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
