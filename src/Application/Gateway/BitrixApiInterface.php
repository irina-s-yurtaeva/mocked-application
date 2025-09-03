<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

interface BitrixApiInterface
{
    public function call(string $method, Client $client, AccessToken $accessToken, array $params = []): array;
}
