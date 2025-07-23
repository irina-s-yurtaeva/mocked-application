<?php

declare(strict_types=1);

namespace MockedApplication\Application\UseCase\Request;

class ApplicationInstallRequest
{
    public function __construct(
		public readonly string $memberId,
		public readonly string $domain,
		public readonly string $clientEndpoint,
		public readonly string $handlerUrl,
	)
	{
	}
}
