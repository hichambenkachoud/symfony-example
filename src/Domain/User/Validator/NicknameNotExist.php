<?php

namespace App\Domain\User\Validator;

use Symfony\Component\Validator\Constraint;

class NicknameNotExist extends Constraint
{
    public string $message = 'Ce pseudo existe déjà.';
}
