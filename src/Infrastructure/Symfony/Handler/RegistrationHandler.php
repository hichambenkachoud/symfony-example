<?php

namespace App\Infrastructure\Symfony\Handler;

use App\Domain\Shared\Exception\BadRequestException;
use App\Domain\User\UseCase\Registration\RegistrationRequest;
use App\Domain\User\UserInterface\Handler\RegistrationHandlerInterface;
use App\Infrastructure\Symfony\Form\RegistrationFormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\User\UserInterface\Handler\RegistrationHandler as BaseHandler;
use Symfony\Component\Validator\ConstraintViolationInterface;

class RegistrationHandler extends BaseHandler
{

    private FormFactoryInterface $formFactory;
    private FormInterface $form;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function handle(Request $request, RegistrationRequest $registrationRequest): bool
    {
        $this->form = $this->formFactory->create(RegistrationFormType::class, $registrationRequest)
            ->handleRequest($request);

        if ($this->form ->isSubmitted() && $this->form->isValid()) {
            try {
                $this->process($registrationRequest);
                return true;
            } catch (BadRequestException $exception) {
                /** @var ConstraintViolationInterface $constraintViolation */
                foreach ($exception->getConstraintViolationList() as $constraintViolation) {
                    $this->form->get($constraintViolation->getPropertyPath())->addError(
                        new FormError($constraintViolation->getMessage())
                    );
                }
            }
        }

        return false;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
