<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application;
use App\Application\Gateway\AccessTokenRefresher;
use App\Application\Gateway\BitrixUrlGenerator;

final class BitrixApi extends Application\Gateway\BitrixApi implements Application\Gateway\BitrixApiInterface
{
	public function __construct(
		BitrixUrlGenerator $urlGenerator,
		AccessTokenRefresher $accessTokenRefresher,
		private readonly Transport $transport,
	) {
		parent::__construct($urlGenerator, $accessTokenRefresher);
	}

	public function processRequest(string $url, array $params): array
	{
		return $this->transport->processRequest($url, $params);
	}
}
