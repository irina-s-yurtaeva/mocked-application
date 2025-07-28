<?php

declare(strict_types=1);

namespace MockedApplication\Domain\Repository;

use src\Domain\Entity\AccessToken;

interface ClientRepositoryInterface
{
    public function saveClient(
		?int $id,
        string $memberId,
        string $domain,
        string $clientEndPoint,
    ): int;

	public function saveAccessToken(
		int $clintId,
		AccessToken $accessToken
	): int;
}
