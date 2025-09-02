<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class AuthUrlProvider implements AuthUrlProviderInterface
{
	public function __construct(private readonly string $baseUrl)
	{
	}

	public function getAuthUrl(): string
	{
		return $this->baseUrl;
	}

	public function getRefreshTokenUrl(): string
	{
		return $this->baseUrl;
	}
}
