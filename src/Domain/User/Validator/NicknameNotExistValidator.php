<?php

namespace App\Domain\User\Validator;

use App\Domain\User\Gateway\UserGateway;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NicknameNotExistValidator extends ConstraintValidator
{
    private UserGateway $userGateway;

    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }


    public function validate($value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $user = $this->userGateway->findOneByNickname($value);
        if (null !== $user) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
