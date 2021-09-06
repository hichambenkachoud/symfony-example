<?php

namespace App\Infrastructure\Php\Provider;

use App\Domain\Shared\Provider\DateProviderInterface;
use DateTimeImmutable;

class DateProvider implements DateProviderInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
