<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use App\Movie\Event\MovieUnderageEvent;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class MovieVoter extends Voter
{
    public const UNDERAGE = 'movie.underage';
    public const IS_CREATOR = 'movie.is_creator';

    public function __construct(protected readonly EventDispatcherInterface $dispatcher)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::UNDERAGE, self::IS_CREATOR])
            && $subject instanceof Movie;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        return match ($attribute) {
            self::UNDERAGE => $this->checkUnderage($subject, $user),
            self::IS_CREATOR => $this->checkIsCreator($subject, $user),
            default => false,
        };
    }

    private function checkUnderage(Movie $movie, User $user): bool
    {
        $vote = match ($movie->getRated()) {
            'G' => true,
            'PG', 'PG-13' => $user->getAge() && $user->getAge() >= 13,
            'R', 'NC-17' => $user->getAge() && $user->getAge() >= 17,
            default => false,
        };

        if (false === $vote) {
            $this->dispatcher->dispatch(new MovieUnderageEvent($movie, $user));
        }

        return $vote;
    }

    private function checkIsCreator(Movie $movie, User $user): bool
    {
        return $this->checkUnderage($movie, $user) && $user === $movie->getCreatedBy();
    }
}
