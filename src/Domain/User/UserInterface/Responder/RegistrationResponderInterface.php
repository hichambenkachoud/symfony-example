<?php

namespace App\Domain\User\UserInterface\Responder;

use App\Domain\User\UserInterface\ViewModel\RegistrationViewModel;
use Symfony\Component\HttpFoundation\Response;

interface RegistrationResponderInterface
{
    public function render(): Response;
    public function authenticate(RegistrationViewModel $viewModel): Response;
}
