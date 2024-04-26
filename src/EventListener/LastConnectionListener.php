<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Clock\Clock;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

final class LastConnectionListener
{
    public function __construct(protected readonly EntityManagerInterface $manager)
    {
    }

    #[AsEventListener(event: InteractiveLoginEvent::class)]
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()?->getUser();
        if ($user instanceof User) {
            $user->setLastConnectedAt(Clock::get()->now());

            $this->manager->flush();
        }
    }
}
