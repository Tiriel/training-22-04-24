<?php

namespace App\Movie\Factory;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Notifier\Notification\Notification;

#[AutoconfigureTag('app.notification_factory')]
interface NotificationFactoryInterface
{
    public function createNotification(string $subject): Notification;

    public static function getIndex(): string;
}
