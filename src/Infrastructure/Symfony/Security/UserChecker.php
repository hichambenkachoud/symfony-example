<?php

namespace App\Infrastructure\Symfony\Security;

use App\Infrastructure\Doctrine\Entity\DoctrineUser;
use App\Infrastructure\Symfony\Security\Exception\AccountSuspendedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof DoctrineUser) {
            return;
        }

        if ($user->isSuspended()) {
            throw new AccountSuspendedException('Your account s suspended.');
        }
    }

    /**
     * @param UserInterface $user
     * @codeCoverageIgnore
     */
    public function checkPostAuth(UserInterface $user): void
    {
    }
}
