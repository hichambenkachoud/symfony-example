<?php

namespace App\Domain\Shared\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class BadRequestException extends \InvalidArgumentException
{
    private ConstraintViolationListInterface $constraintViolationList;

    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct();
        $this->constraintViolationList = $constraintViolationList;
    }

    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
