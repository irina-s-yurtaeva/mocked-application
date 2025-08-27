<?php

declare(strict_types=1);

namespace App\Application\Port;

interface AccessTokenProvider
{
    public function getAccessTokenForTenant(string $tenantId): string;
}
