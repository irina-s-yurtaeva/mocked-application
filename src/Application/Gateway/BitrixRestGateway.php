<?php

declare(strict_types=1);

namespace MockedApplication\Application\Gateway;

interface BitrixRestGateway
{
    public function call(string $method, array $params = []): array;

	public function getAccessTocken(string $method, array $params = []): array;
}
