<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface BitrixRestGateway
{
    public function call(string $method, array $params = []): array;

	public function getAccessToken(string $method, array $params = []): array;
}
