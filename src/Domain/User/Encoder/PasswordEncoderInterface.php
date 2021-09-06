<?php

namespace App\Domain\User\Encoder;

use App\Domain\User\Entity\User;

interface PasswordEncoderInterface
{
    public function encodePassword(string $plainPassword): string;
}
