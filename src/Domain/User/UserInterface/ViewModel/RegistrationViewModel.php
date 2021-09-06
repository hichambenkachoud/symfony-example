<?php

namespace App\Domain\User\UserInterface\ViewModel;

use App\Domain\User\Entity\User;
use App\Domain\User\UseCase\Registration\RegistrationResponse;

class RegistrationViewModel
{
    private User $user;

    public static function createFromResponse(RegistrationResponse $response): self
    {
        $view = new self();
        $view->user = $response->getUser();

        return $view;
    }


    public function getUser(): User
    {
        return $this->user;
    }
}
