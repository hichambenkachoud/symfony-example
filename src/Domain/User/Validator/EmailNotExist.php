<?php

namespace App\Domain\User\Validator;

use Symfony\Component\Validator\Constraint;

class EmailNotExist extends Constraint
{
    public string $message = 'Cette adresse email existe déjà.';

    public function validatedBy(): string
    {
        return EmailNotExistValidator::class;
    }
}
