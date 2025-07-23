<?php

declare(strict_types=1);

namespace MockedApplication\Application\Gateway;

use MockedApplication\Infrastructure\Exception\BitrixApiException;

interface BitrixRestGateway
{
    /**
     * @param string $method
     * @param array<string,mixed> $params
     * @param string|null $accessToken
     *
     * @return array<string,mixed>
     *
     * @throws BitrixApiException
     */
    public function call(string $method, array $params = [], ?string $accessToken = null): array;
}
