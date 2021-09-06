<?php

namespace App\Infrastructure\Doctrine\Factory;

use App\Domain\User\Entity\User;
use App\Infrastructure\Doctrine\Entity\DoctrineUser;

class UserFactory
{
    public static function createFromDomainUser(User $user, bool $isAdmin = false): DoctrineUser
    {
        $doctrineUser = new DoctrineUser();
        $doctrineUser->setEmail($user->getEmail());
        $doctrineUser->setNickname($user->getNickname());
        $doctrineUser->setPassword($user->getPassword());
        $doctrineUser->setCreatedAt($user->getCreatedAt());
        if ($isAdmin) {
            $doctrineUser->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        }

        return $doctrineUser;
    }
}
