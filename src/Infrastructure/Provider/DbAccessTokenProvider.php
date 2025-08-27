<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use Doctrine\DBAL\Connection;
use App\Application\Port\AccessTokenProvider;

final class DbAccessTokenProvider implements AccessTokenProvider
{
    public function __construct(private Connection $connection) {}

    public function getAccessTokenForTenant(string $tenantId): string
    {
        $sql = 'SELECT access_token FROM client_settings WHERE member_id = ?';
        $token = $this->connection->fetchOne($sql, [$tenantId]);

        return is_string($token) ? $token : '';
    }
}
