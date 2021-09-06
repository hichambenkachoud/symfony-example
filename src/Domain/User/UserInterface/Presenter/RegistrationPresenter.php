<?php

namespace App\Domain\User\UserInterface\Presenter;

use App\Domain\User\UseCase\Registration\RegistrationResponse;
use App\Domain\User\UserInterface\ViewModel\RegistrationViewModel;

class RegistrationPresenter implements RegistrationPresenterInterface
{
    private RegistrationViewModel $registrationViewModel;

    public function present(RegistrationResponse $registrationResponse): void
    {
        $this->registrationViewModel = RegistrationViewModel::createFromResponse($registrationResponse);
    }

    public function getViewModel(): RegistrationViewModel
    {
        return $this->registrationViewModel;
    }
}
