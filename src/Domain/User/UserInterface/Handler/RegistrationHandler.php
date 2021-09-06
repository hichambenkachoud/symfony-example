<?php

namespace App\Domain\User\UserInterface\Handler;

use App\Domain\User\UseCase\Registration\RegistrationInterface;
use App\Domain\User\UseCase\Registration\RegistrationRequest;
use App\Domain\User\UserInterface\Presenter\RegistrationPresenterInterface;

abstract class RegistrationHandler implements RegistrationHandlerInterface
{
    private RegistrationInterface $registration;

    private RegistrationPresenterInterface $presenter;

    /**
     * @required
     */
    public function setRegistration(RegistrationInterface $registration): void
    {
        $this->registration = $registration;
    }

    /**
     * @required
     */
    public function setPresenter(RegistrationPresenterInterface $presenter): void
    {
        $this->presenter = $presenter;
    }

    public function process(RegistrationRequest $request): void
    {
        $this->registration->execute($request, $this->presenter);
    }
}
