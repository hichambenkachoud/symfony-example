<?php

namespace App\Infrastructure\Symfony\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method string getUserIdentifier()
 */
class SecurityUser implements UserInterface, PasswordAuthenticatedUserInterface
{

    private string $email;

    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return ["ROLE_USER"];
    }

    public function getSalt()
    {
    }

    public function eraseCredentials(): void
    {
    }

    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
