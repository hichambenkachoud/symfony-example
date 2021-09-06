<?php

namespace App\Infrastructure\Symfony\Security\Encoder;

use App\Domain\User\Encoder\PasswordEncoderInterface;
use App\Infrastructure\Symfony\Security\SecurityUser;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserPasswordEncoder implements PasswordEncoderInterface
{

    private PasswordHasherFactoryInterface $userPasswordEncoder;

    public function __construct(PasswordHasherFactoryInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function encodePassword(string $plainPassword): string
    {
        return $this->userPasswordEncoder->getPasswordHasher(SecurityUser::class)->hash($plainPassword);
    }
}
