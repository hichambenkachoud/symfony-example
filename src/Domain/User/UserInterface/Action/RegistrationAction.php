<?php

namespace App\Domain\User\UserInterface\Action;

use App\Domain\User\UseCase\Registration\RegistrationRequest;
use App\Domain\User\UserInterface\Handler\RegistrationHandlerInterface;
use App\Domain\User\UserInterface\Presenter\RegistrationPresenterInterface;
use App\Domain\User\UserInterface\Responder\RegistrationResponderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationAction
{

    private RegistrationResponderInterface $responder;
    private RegistrationPresenterInterface $presenter;
    private RegistrationHandlerInterface $registrationHandler;

    public function __construct(
        RegistrationResponderInterface $responder,
        RegistrationPresenterInterface $presenter,
        RegistrationHandlerInterface $registrationHandler
    ) {
        $this->responder = $responder;
        $this->presenter = $presenter;
        $this->registrationHandler = $registrationHandler;
    }

    public function __invoke(Request $request): Response
    {
        $registrationRequest = new RegistrationRequest();

        if ($this->registrationHandler->handle($request, $registrationRequest)) {
            return $this->responder->authenticate($this->presenter->getViewModel());
        }

        return $this->responder->render();
    }
}
