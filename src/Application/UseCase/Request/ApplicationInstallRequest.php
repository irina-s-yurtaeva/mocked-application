<?php

declare(strict_types=1);

namespace MockedApplication\Application\UseCase\Request;

class ApplicationInstallRequest
{
    public function __construct(
		public readonly string $memberId,
		public readonly string $accessToken,
		public readonly string $expiresIn,
		public readonly string $applicationToken,
		public readonly string $refreshToken,
		public readonly string $domain,
		public readonly string $clientEndpoint,
		public readonly string $handlerUrl,
	)
	{
	}
}
