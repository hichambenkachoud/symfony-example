<?php

namespace App\Domain\User\UserInterface\Handler;

use App\Domain\User\UseCase\Registration\RegistrationRequest;
use Symfony\Component\HttpFoundation\Request;

interface RegistrationHandlerInterface
{

    public function handle(Request $request, RegistrationRequest $registrationRequest): bool;
}
