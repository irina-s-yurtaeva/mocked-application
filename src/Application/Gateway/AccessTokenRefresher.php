<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\Entity\AccessToken;
use App\Domain\Repository\ClientRepositoryInterface;

abstract class AccessTokenRefresher implements AccessTokenRefresherInterface
{
	public function __construct(
		private readonly string  $clientId,
		private readonly string $clientSecret,
		private readonly AuthUrlProviderInterface $urlProvider,
		protected ClientRepositoryInterface $clientRepository,
	) {
	}

	public function refresh(AccessToken $token): AccessToken
	{
		$result = $this->processRequest(
			$this->urlProvider->getRefreshTokenUrl(),
			[
				'client_id' => $this->clientId,
				'grant_type' => 'refresh_token',
				'client_secret' => $this->clientSecret,
				'refresh_token' => $token->getRefreshToken(),
			]
		);

		$token
			->setAccessToken($result['access_token'])
			->setRefreshToken($result['refresh_token'])
			->setExpiresIn((new \DateTimeImmutable())->setTimestamp((int)$result['expires']));
		;

		$this->clientRepository->saveAccessToken($token);

		return $token;
	}

	abstract protected function processRequest($url, array $params): array;
}
