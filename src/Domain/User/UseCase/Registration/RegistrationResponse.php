<?php

namespace App\Domain\User\UseCase\Registration;

use App\Domain\User\Entity\User;

class RegistrationResponse
{
    private User $user;

    public static function create(User $user): RegistrationResponse
    {
        $response =  new self();
        $response->user = $user;

        return $response;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
