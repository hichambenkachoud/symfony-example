<?php

namespace App\Domain\User\Entity;

use App\Domain\User\Encoder\PasswordEncoderInterface;
use DateTimeImmutable;

class User
{
    private ?string $nickname;
    private ?string $email;
    private ?string $password = null;
    private DateTimeImmutable $createdAt;

    public function __construct(
        ?string $nickname,
        ?string $email,
        DateTimeImmutable $createdAt,
        ?string $password = null
    ) {
        $this->nickname = $nickname;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->password = $password;
    }


    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function encodePassword(PasswordEncoderInterface $encoder, string $plainPassword): void
    {
        $this->password = $encoder->encodePassword($plainPassword);
    }
}
