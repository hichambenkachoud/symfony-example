<?php

namespace App\Security;

use App\Entity\User;
use App\Security\Exception\AccountSuspendedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
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
