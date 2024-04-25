<?php

namespace App\Movie\Notifier;

use App\Entity\Movie;
use App\Entity\User;
use App\Movie\Factory\NotificationFactoryInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class NewMovieNotifier
{
    public function __construct(
        protected readonly NotifierInterface $notifier,
        /** @var NotificationFactoryInterface[] $factories */
        #[TaggedIterator('app.notification_factory', defaultIndexMethod: 'getIndex')]
        protected iterable $factories,
    )
    {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function send(Movie $movie, User $user): void
    {
        $message = sprintf('The movie "%s" has been added to our database!', $movie->getTitle());
        $notification = $this->factories[$user->getPreferredChannel()]
            ->createNotification($message);

        $this->notifier->send($notification, new Recipient($user->getEmail()));
    }
}
