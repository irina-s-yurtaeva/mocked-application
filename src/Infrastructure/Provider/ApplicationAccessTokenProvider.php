<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Provider;

use Doctrine\DBAL\Connection;
use MockedApplication\Application;

final class ApplicationAccessTokenProvider implements Application\Gateway\AccessTokenProvider
{
    public function __construct(
		protected string $accessToken,
		protected string $expiresIn,
		protected string $applicationToken,
		protected string $refreshToken,
    )
    {

    }

    public function getAccessToken(): string
    {
		return $this->accessToken;
    }

	public function getRefreshToken(): string
	{
		return $this->refreshToken;
	}

	public function getExpiresIn(): string
	{
		return $this->expiresIn;
	}

	public function getApplicationToken(): string
	{
		return $this->applicationToken;
	}

	public function refreshAccessToken(array $data): void
	{

	}
}
