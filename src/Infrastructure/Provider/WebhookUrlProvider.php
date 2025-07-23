<?php

declare(strict_types=1);

namespace src\Infrastructure\Provider;

use MockedApplication\Application\Gateway\BitrixUrlProvider;

class WebhookUrlProvider extends BitrixUrlProvider
{
	public function __construct(
		protected string $webhookUrl,
	)
	{
	}

	public function getAuthenticationUrl(): string
	{
		return '';
	}

	public function getEndpointUrl(): string
	{
		return $this->webhookUrl;
	}
}
