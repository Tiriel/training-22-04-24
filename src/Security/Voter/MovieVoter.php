<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MovieVoter extends Voter
{
    public const UNDERAGE = 'movie.underage';
    public const IS_CREATOR = 'movie.is_creator';

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
        return match ($movie->getRated()) {
            'G' => true,
            'PG', 'PG-13' => $user->getAge() && $user->getAge() >= 13,
            'R', 'NC-17' => $user->getAge() && $user->getAge() >= 17,
            default => false,
        };
    }

    private function checkIsCreator(Movie $movie, User $user): bool
    {
        return $this->checkUnderage($movie, $user) && $user === $movie->getCreatedBy();
    }
}
