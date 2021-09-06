<?php

namespace App\Domain\User\Gateway;

use App\Domain\User\Entity\User;

interface UserGateway
{
    public function register(User $user): void;

    public function findOneByEmail(string $username): ?User;
}
