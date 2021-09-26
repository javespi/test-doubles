<?php

declare(strict_types=1);

test('asserts true is true', function (): void {
    $this->assertTrue(true);

    expect(true)->toBeTrue();
});
