<?php

declare(strict_types=1);

namespace MockedApplication\Domain\Repository;

interface ClientSettingsRepositoryInterface
{
    public function saveClientSettings(
        string $memberId,
        string $accessToken,
        string $expiresIn,
        string $applicationToken,
        string $refreshToken,
        string $domain,
        string $clientEndpoint,
        int $userId = 0,
        array $addParameters = []
    ): int;
}
