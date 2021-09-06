<?php

namespace App\Domain\User\UseCase\Registration;

interface RegistrationPresenterInterface
{
    public function present(RegistrationResponse $registrationResponse): void;
}
