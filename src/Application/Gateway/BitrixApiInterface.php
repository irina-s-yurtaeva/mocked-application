<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\Entity\AccessToken;

interface BitrixApiInterface
{
    public function call(string $method, AccessToken $accessToken, array $params = []): array;
}
