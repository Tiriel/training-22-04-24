<?php

namespace App\Movie\Notifier\Factory;

use App\Movie\Notifier\Factory\NotificationFactoryInterface;
use App\Movie\Notifier\Notifications\DiscordNotification;
use Symfony\Component\Notifier\Notification\Notification;

class DiscordNotificationFactory implements NotificationFactoryInterface
{

    public function createNotification(string $subject): Notification
    {
        return new DiscordNotification($subject);
    }

    public static function getIndex(): string
    {
        return 'discord';
    }
}
