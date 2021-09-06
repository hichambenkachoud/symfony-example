<?php

namespace App\Domain\User\UserInterface\Presenter;

use App\Domain\User\UseCase\Registration\RegistrationPresenterInterface as BasePresenter;
use App\Domain\User\UserInterface\ViewModel\RegistrationViewModel;

interface RegistrationPresenterInterface extends BasePresenter
{
    public function getViewModel(): RegistrationViewModel;
}
