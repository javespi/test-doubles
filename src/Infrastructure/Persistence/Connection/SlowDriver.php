<?php

declare(strict_types=1);

namespace TestDoubles\Infrastructure\Persistence\Connection;

class SlowDriver implements Driver
{
    public function select(string $query): array
    {
        sleep(1);

        return [
            'id' => 1,
            'data' => 'sorry im lazy',
        ];
    }
}
