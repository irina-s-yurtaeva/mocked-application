<?php

declare(strict_types=1);

namespace MockedApplication\Application\Port;

interface AccessTokenProvider
{
    public function getAccessTokenForTenant(string $tenantId): string;
}
