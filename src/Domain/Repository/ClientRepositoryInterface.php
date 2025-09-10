<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

interface ClientRepositoryInterface
{
	public function save(Client $client): Client;

	public function saveClientAccessToken(Client $client, AccessToken $accessToken): void;

	public function saveAccessToken(
		AccessToken $accessToken
	): void;

	public function findAll(): array;

	public function findOneByMemberId(string $memberId): ?Client;

	public function findOneByApplicationToken(string $applicationToken): ?Client;
}
