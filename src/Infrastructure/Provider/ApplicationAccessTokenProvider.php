<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use Doctrine\DBAL\Connection;
use App\Application;

final class ApplicationAccessTokenProvider implements Application\Gateway\AccessTokenProvider
{
    public function __construct(
		protected string $accessToken,
		protected string $expiresIn,
		protected string $applicationToken,
		protected string $refreshToken,
	    protected ?int $userId = null,
	    protected ?int $userFullName = null,

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

	public function getUserId(array $data): ?int
	{
		return $this->userId;
	}

	public function getUserFullNAme(array $data): ?string
	{
		return $this->userFullName;
	}
}
