<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Repository;

use MockedApplication\Domain\Repository\ClientSettingsRepositoryInterface;
use Doctrine\DBAL\Connection;

class ClientSettingsRepository implements ClientSettingsRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function saveClientSettings(
        string $memberId,
        string $accessToken,
        string $expiresIn,
        string $applicationToken,
        string $refreshToken,
        string $domain,
        string $clientEndpoint
    ): int {
        $this->connection->insert('client_settings', [
            'member_id' => $memberId,
            'access_token' => $accessToken,
            'expires_in' => $expiresIn,
            'application_token' => $applicationToken,
            'refresh_token' => $refreshToken,
            'domain' => $domain,
            'client_endpoint' => $clientEndpoint,
        ]);

        return (int)$this->connection->lastInsertId();
    }
}
