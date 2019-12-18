<?php

declare(strict_types=1);

namespace TestDoubles\Infrastructure\Persistence\Connection;

interface Driver
{
    public function select(string $query): array;
}
