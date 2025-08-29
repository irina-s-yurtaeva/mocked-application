<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

interface ClientRepositoryInterface
{
	public function saveClient(
		string $memberId,
		string $domain,
		string $clientEndPoint,
	): int;

	public function save(Client $client): void;

	public function saveAccessToken(
		int $clintId,
		AccessToken $accessToken
	): int;

	public function findAll(): array;

	public function findOneByMemberId(string $memberId): ?Client;
}
