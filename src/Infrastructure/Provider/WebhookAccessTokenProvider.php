<?php

declare(strict_types=1);

namespace src\Infrastructure\Provider;

use Doctrine\DBAL\Connection;
use App\Application;

final class WebhookAccessTokenProvider implements Application\Gateway\AccessTokenProvider
{
    public function getAccessToken(): string
    {
		return '';
	}

	public function getRefreshToken(): string
	{
		return '';
	}

	public function getExpiresIn(): string
	{
		return '';
	}

	public function getApplicationToken(): string
	{
		return '';
	}

	public function getUserId(array $data): ?int
	{
		return null;
	}

	public function getUserFullNAme(array $data): ?string
	{
		return null;
	}


	public function refreshAccessToken(array $data): void
	{

	}
}
