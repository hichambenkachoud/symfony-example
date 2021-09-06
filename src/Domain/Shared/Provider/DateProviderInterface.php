<?php

namespace App\Domain\Shared\Provider;

use DateTimeImmutable;

interface DateProviderInterface
{
    public function now(): DateTimeImmutable;
}
