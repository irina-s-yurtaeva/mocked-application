<?php

declare(strict_types=1);

namespace src\Infrastructure\Provider;

use Doctrine\DBAL\Connection;
use MockedApplication\Application;

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

	public function refreshAccessToken(array $data): void
	{

	}
}
