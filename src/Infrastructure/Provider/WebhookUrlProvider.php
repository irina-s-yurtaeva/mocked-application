<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use App\Application\Gateway\BitrixUrlProvider;

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
