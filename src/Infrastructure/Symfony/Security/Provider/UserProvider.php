<?php

namespace App\Infrastructure\Symfony\Security\Provider;

use App\Domain\User\Gateway\UserGateway;
use App\Infrastructure\Symfony\Security\SecurityUser;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method UserInterface loadUserByIdentifier(string $identifier)
 */
class UserProvider implements UserProviderInterface
{
    private UserGateway $userGateway;

    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function refreshUser(UserInterface $user): SecurityUser
    {
        $user = $this->userGateway->findOneByEmail($user->getUsername());

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new SecurityUser($user->getEmail(), $user->getPassword());
    }

    public function supportsClass(string $class): bool
    {
        return SecurityUser::class === $class;
    }

    public function loadUserByUsername(string $username): SecurityUser
    {
        $user = $this->userGateway->findOneByEmail($username);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new SecurityUser($user->getEmail(), $user->getPassword());
    }
}
