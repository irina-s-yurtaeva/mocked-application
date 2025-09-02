<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\AuthUrlProviderInterface;
use App\Domain\Repository\ClientRepositoryInterface;

class AccessTokenRefresher extends \App\Application\Gateway\AccessTokenRefresher
{
	public function __construct(
		string  $clientId,
		string $clientSecret,
		AuthUrlProviderInterface $urlProvider,
		ClientRepositoryInterface $clientRepository,
		private readonly Transport $transport,
	) {
		parent::__construct($clientId, $clientSecret, $urlProvider, $clientRepository);
	}

	protected function processRequest($url, array $params): array
	{
		return $this->transport->processRequest($url, $params);
	}
}
