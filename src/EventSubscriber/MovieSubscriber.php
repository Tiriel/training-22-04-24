<?php

namespace App\EventSubscriber;

use App\Movie\Event\MovieUnderageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MovieSubscriber implements EventSubscriberInterface
{
    public function __construct(protected readonly MailerInterface $mailer)
    {
    }

    public function onMovieUnderageEvent(MovieUnderageEvent $event): void
    {
        $user = $event->getUser();
        $movie = $event->getMovie();
        $email = (new Email())
            ->addTo('admin@sensiotv.com')
            ->subject('Underage viewing!')
            ->text(sprintf('User %s has attempted to view movie "%s"', $user->getEmail(), $movie->getTitle()))
            ;

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MovieUnderageEvent::class => 'onMovieUnderageEvent',
        ];
    }
}
