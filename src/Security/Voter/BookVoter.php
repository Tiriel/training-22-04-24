<?php

namespace App\Security\Voter;

use App\Entity\Book;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BookVoter extends Voter
{
    public const IS_CREATOR = 'book.is_creator';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::IS_CREATOR === $attribute
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Book $subject */
        return match ($attribute) {
            self::IS_CREATOR => $user === $subject->getCreatedBy(),
            default => false,
        };
    }
}
