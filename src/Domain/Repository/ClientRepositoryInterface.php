<?php

declare(strict_types=1);

namespace MockedApplication\Domain\Repository;

use src\Domain\Entity\AccessToken;

interface ClientRepositoryInterface
{
    public function saveClient(
        string $memberId,
        string $domain,
    ): int;

	public function saveAccessToken(
		int $clintId,

	): int;

}
