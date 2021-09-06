<?php

namespace App\Domain\User\UseCase\Registration;

interface RegistrationInterface
{
    public function execute(RegistrationRequest $request, RegistrationPresenterInterface $presenter): void;
}
