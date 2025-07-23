<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Provider;

use MockedApplication\Application\Gateway\BitrixUrlProvider;

class ApplicationUrlProvider extends BitrixUrlProvider
{
	public function __construct(
		protected string $oauthServerUrl,
		protected string $endPointUrl
	)
	{

	}

	public function getAuthenticationUrl(): string
	{
		return $this->oauthServerUrl;
	}

	public function getEndpointUrl(): string
	{
		return $this->endPointUrl;
	}
}
